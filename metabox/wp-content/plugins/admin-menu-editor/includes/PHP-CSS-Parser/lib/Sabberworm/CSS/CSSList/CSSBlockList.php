<?php

namespace Sabberworm\CSS\CSSList;

use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\RuleSet\RuleSet;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\Value\ValueList;
use Sabberworm\CSS\Value\CSSFunction;

/**
 * A CSSBlockList is a CSSList whose DeclarationBlocks are guaranteed to contain valid declaration blocks or at-rules.
 * Most CSSLists conform to this category but some at-rules (such as @keyframes) do not.
 */
abstract class CSSBlockList extends CSSList {
	protected function allDeclarationBlocks(&$aResult) {
		foreach ($this->aContents as $mContent) {
			if ($mContent instanceof DeclarationBlock) {
				$aResult[] = $mContent;
			} else if ($mContent instanceof CSSBlockList) {
				$mContent->allDeclarationBlocks($aResult);
			}
		}
	}

	protected function allRuleSets(&$aResult) {
		foreach ($this->aContents as $mContent) {
			if ($mContent instanceof RuleSet) {
				$aResult[] = $mContent;
			} else if ($mContent instanceof CSSBlockList) {
				$mContent->allRuleSets($aResult);
			}
		}
	}

	protected function allValues($oElement, &$aResult, $sSearchString = null, $bSearchInFunctionArguments = false) {
		if ($oElement instanceof CSSBlockList) {
			foreach ($oElement->getContents() as $oContent) {
				$this->allValues($oContent, $aResult, $sSearchString, $bSearchInFunctionArguments);
			}
		} else if ($oElement instanceof RuleSet) {
			foreach ($oElement->getRules($sSearchString) as $oRule) {
				$this->allValues($oRule, $aResult, $sSearchString, $bSearchInFunctionArguments);
			}
		} else if ($oElement instanceof Rule) {
			$this->allValues($oElement->getValue(), $aResult, $sSearchString, $bSearchInFunctionArguments);
		} else if ($oElement instanceof ValueList) {
			if ($bSearchInFunctionArguments || !($oElement instanceof CSSFunction)) {
				foreach ($oElement->getListComponents() as $mComponent) {
					$this->allValues($mComponent, $aResult, $sSearchString, $bSearchInFunctionArguments);
				}
			}
		} else {
			//Non-List Value or CSSString (CSS identifier)
			$aResult[] = $oElement;
		}
	}

	protected function allSelectors(&$aResult, $sSpecificitySearch = null) {
		$aDeclarationBlocks = array();
		$this->allDeclarationBlocks($aDeclarationBlocks);
		foreach ($aDeclarationBlocks as $oBlock) {
			foreach ($oBlock->getSelectors() as $oSelector) {
				if ($sSpecificitySearch === null) {
					$aResult[] = $oSelector;
				} else {
					//WSH: The original implementation used eval to compare specificity. I rewrote it
					//to use version_compare instead to prevent false positives in vulnerability scanners.
					//It's a bit of a hack, but it's shorter than a big switch statement.
					$specificity = $oSelector->getSpecificity();
					$isMatch = false;
					if ( preg_match(
						'/^(?P<operator>(?:[<>]=?)|(?:!==?)|={2,3})\s*?(?P<number>\d++)$/',
						trim($sSpecificitySearch),
						$matches
					) ) {
						$isMatch = version_compare((string)$specificity, $matches['number'], $matches['operator']);
					}
					if ($isMatch) {
						$aResult[] = $oSelector;
					}
				}
			}
		}
	}

}
