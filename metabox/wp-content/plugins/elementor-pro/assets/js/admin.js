/*! elementor-pro - v2.4.5 - 18-02-2019 */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 55);
/******/ })
/************************************************************************/
/******/ ({

/***/ 55:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var modules = {
	widget_template_edit_button: __webpack_require__(56),
	forms_integrations: __webpack_require__(58),
	AssetsManager: __webpack_require__(60),
	RoleManager: __webpack_require__(65),
	ThemeBuilder: __webpack_require__(67)
};

window.elementorProAdmin = {
	widget_template_edit_button: new modules.widget_template_edit_button(),
	forms_integrations: new modules.forms_integrations(),
	assetsManager: new modules.AssetsManager(),
	roleManager: new modules.RoleManager(),
	themeBuilder: new modules.ThemeBuilder()
};

jQuery(function () {
	elementorProAdmin.assetsManager.fontManager.init();
	elementorProAdmin.roleManager.advancedRoleManager.init();
});

/***/ }),

/***/ 56:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var EditButton = __webpack_require__(57);
	this.editButton = new EditButton();
};

/***/ }),

/***/ 57:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var self = this;

	self.init = function () {
		jQuery(document).on('change', '.elementor-widget-template-select', function () {
			var $this = jQuery(this),
			    templateID = $this.val(),
			    $editButton = $this.parents('p').find('.elementor-edit-template'),
			    type = $this.find('[value="' + templateID + '"]').data('type');

			if ('page' !== type) {
				// 'widget' is editable only from Elementor page
				$editButton.hide();

				return;
			}

			var editUrl = ElementorProConfig.i18n.home_url + '?p=' + templateID + '&elementor';

			$editButton.prop('href', editUrl).show();
		});
	};

	self.init();
};

/***/ }),

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var ApiValidations = __webpack_require__(59);

	this.dripButton = new ApiValidations('drip_api_token');
	this.getResponse = new ApiValidations('getresponse_api_key');
	this.convertKit = new ApiValidations('convertkit_api_key');
	this.mailChimp = new ApiValidations('mailchimp_api_key');
	this.mailerLite = new ApiValidations('mailerlite_api_key');
	this.activeCcampaign = new ApiValidations('activecampaign_api_key', 'activecampaign_api_url');
};

/***/ }),

/***/ 59:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function (key, fieldID) {
	var self = this;
	self.cacheElements = function () {
		this.cache = {
			$button: jQuery('#elementor_pro_' + key + '_button'),
			$apiKeyField: jQuery('#elementor_pro_' + key),
			$apiUrlField: jQuery('#elementor_pro_' + fieldID)
		};
	};
	self.bindEvents = function () {
		this.cache.$button.on('click', function (event) {
			event.preventDefault();
			self.validateApi();
		});

		this.cache.$apiKeyField.on('change', function () {
			self.setState('clear');
		});
	};
	self.validateApi = function () {
		this.setState('loading');
		var apiKey = this.cache.$apiKeyField.val();

		if ('' === apiKey) {
			this.setState('clear');
			return;
		}

		if (this.cache.$apiUrlField.length && '' === this.cache.$apiUrlField.val()) {
			this.setState('clear');
			return;
		}

		jQuery.post(ajaxurl, {
			action: self.cache.$button.data('action'),
			api_key: apiKey,
			api_url: this.cache.$apiUrlField.val(),
			_nonce: self.cache.$button.data('nonce')
		}).done(function (data) {
			if (data.success) {
				self.setState('success');
			} else {
				self.setState('error');
			}
		}).fail(function () {
			self.setState();
		});
	};
	self.setState = function (type) {
		var classes = ['loading', 'success', 'error'],
		    currentClass,
		    classIndex;

		for (classIndex in classes) {
			currentClass = classes[classIndex];
			if (type === currentClass) {
				this.cache.$button.addClass(currentClass);
			} else {
				this.cache.$button.removeClass(currentClass);
			}
		}
	};
	self.init = function () {
		this.cacheElements();
		this.bindEvents();
	};
	self.init();
};

/***/ }),

/***/ 60:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var FontManager = __webpack_require__(61),
	    TypekitAdmin = __webpack_require__(64);
	this.fontManager = new FontManager();
	this.typekit = new TypekitAdmin();
};

/***/ }),

/***/ 61:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var self = this;

	self.fields = {
		upload: __webpack_require__(62),
		repeater: __webpack_require__(63)
	};

	self.selectors = {
		editPageClass: 'post-type-elementor_font',
		title: '#title',
		repeaterBlock: '.repeater-block',
		repeaterTitle: '.repeater-title',
		removeRowBtn: '.remove-repeater-row',
		editRowBtn: '.toggle-repeater-row',
		closeRowBtn: '.close-repeater-row',
		styleInput: '.font_style',
		weightInput: '.font_weight',
		customFontsMetaBox: '#elementor-font-custommetabox',
		closeHandle: 'button.handlediv',
		toolbar: '.elementor-field-toolbar',
		inlinePreview: '.inline-preview',
		fileUrlInput: '.elementor-field-file input[type="text"]'
	};

	self.fontLabelTemplate = '<ul class="row-font-label"><li class="row-font-weight">{{weight}}</li><li class="row-font-style">{{style}}</li><li class="row-font-preview">{{preview}}</li>{{toolbar}}</ul>';

	self.renderTemplate = function (tpl, data) {
		var re = /{{([^}}]+)?}}/g,
		    match;
		while (match = re.exec(tpl)) {
			// eslint-disable-line no-cond-assign
			tpl = tpl.replace(match[0], data[match[1]]);
		}
		return tpl;
	};

	self.ucFirst = function (string) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};

	self.getPreviewStyle = function ($table) {
		var fontFamily = jQuery(self.selectors.title).val(),
		    style = $table.find('select' + self.selectors.styleInput).first().val(),
		    weight = $table.find('select' + self.selectors.weightInput).first().val();

		return {
			style: self.ucFirst(style),
			weight: self.ucFirst(weight),
			styleAttribute: 'font-family: ' + fontFamily + ' ;font-style: ' + style + '; font-weight: ' + weight + ';'
		};
	};

	self.updateRowLabel = function (event, $table) {
		var $block = $table.closest(self.selectors.repeaterBlock),
		    $deleteBtn = $block.find(self.selectors.removeRowBtn).first(),
		    $editBtn = $block.find(self.selectors.editRowBtn).first(),
		    $closeBtn = $block.find(self.selectors.closeRowBtn).first(),
		    $toolbar = $table.find(self.selectors.toolbar).last().clone(),
		    previewStyle = self.getPreviewStyle($table),
		    toolbarHtml;

		if ($editBtn.length > 0) {
			$editBtn.not(self.selectors.toolbar + ' ' + self.selectors.editRowBtn).remove();
		}

		if ($closeBtn.length > 0) {
			$closeBtn.not(self.selectors.toolbar + ' ' + self.selectors.closeRowBtn).remove();
		}

		if ($deleteBtn.length > 0) {
			$deleteBtn.not(self.selectors.toolbar + ' ' + self.selectors.removeRowBtn).remove();
		}

		toolbarHtml = jQuery('<li class="row-font-actions">').append($toolbar)[0].outerHTML;

		return self.renderTemplate(self.fontLabelTemplate, {
			weight: '<span class="label">Weight:</span>' + previewStyle.weight,
			style: '<span class="label">Style:</span>' + previewStyle.style,
			preview: '<span style="' + previewStyle.styleAttribute + '">Elementor is making the web beautiful</span>',
			toolbar: toolbarHtml
		});
	};

	self.onRepeaterToggleVisible = function (event, $btn, $table) {
		var $previewElement = $table.find(self.selectors.inlinePreview),
		    previewStyle = self.getPreviewStyle($table);

		$previewElement.attr('style', previewStyle.styleAttribute);
	};

	self.onRepeaterNewRow = function (event, $btn, $block) {
		$block.find(self.selectors.removeRowBtn).first().remove();
		$block.find(self.selectors.editRowBtn).first().remove();
		$block.find(self.selectors.closeRowBtn).first().remove();
	};

	self.maybeToggle = function (event) {
		event.preventDefault();

		if (jQuery(this).is(':visible') && !jQuery(event.target).hasClass(self.selectors.editRowBtn)) {
			jQuery(this).find(self.selectors.editRowBtn).click();
		}
	};

	self.onInputChange = function (event) {
		var $el = jQuery(event.target).next();

		self.fields.upload.setFields($el);
		self.fields.upload.setLabels($el);
		self.fields.upload.replaceButtonClass($el);
	};

	self.bind = function () {
		jQuery(document).on('repeaterComputedLabel', this.updateRowLabel).on('onRepeaterToggleVisible', this.onRepeaterToggleVisible).on('onRepeaterNewRow', this.onRepeaterNewRow).on('click', this.selectors.repeaterTitle, this.maybeToggle).on('input', this.selectors.fileUrlInput, this.onInputChange.bind(this));
	};

	self.removeCloseHandle = function () {
		jQuery(this.selectors.closeHandle).remove();
		jQuery(this.selectors.customFontsMetaBox).removeClass('closed').removeClass('postbox');
	};

	self.titleRequired = function () {
		jQuery(self.selectors.title).prop('required', true);
	};

	self.init = function () {
		if (!jQuery('body').hasClass(self.selectors.editPageClass)) {
			return;
		}

		this.removeCloseHandle();
		this.titleRequired();
		this.bind();
		this.fields.upload.init();
		this.fields.repeater.init();
	};
};

/***/ }),

/***/ 62:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = {
	$btn: null,
	fileId: null,
	fileUrl: null,
	fileFrame: [],

	selectors: {
		uploadBtnClass: 'elementor-upload-btn',
		clearBtnClass: 'elementor-upload-clear-btn',
		uploadBtn: '.elementor-upload-btn',
		clearBtn: '.elementor-upload-clear-btn'
	},

	hasValue: function hasValue() {
		return '' !== jQuery(this.fileUrl).val();
	},

	setLabels: function setLabels($el) {
		if (!this.hasValue()) {
			$el.val($el.data('upload_text'));
		} else {
			$el.val($el.data('remove_text'));
		}
	},

	setFields: function setFields(el) {
		var self = this;
		self.fileUrl = jQuery(el).prev();
		self.fileId = jQuery(self.fileUrl).prev();
	},

	setUploadParams: function setUploadParams(ext, name) {
		var self = this;
		self.fileFrame[name].uploader.uploader.param('uploadeType', ext);
		self.fileFrame[name].uploader.uploader.param('uploadeTypecaller', 'elementor-admin-upload');
	},

	replaceButtonClass: function replaceButtonClass(el) {
		if (this.hasValue()) {
			jQuery(el).removeClass(this.selectors.uploadBtnClass).addClass(this.selectors.clearBtnClass);
		} else {
			jQuery(el).removeClass(this.selectors.clearBtnClass).addClass(this.selectors.uploadBtnClass);
		}
		this.setLabels(el);
	},

	uploadFile: function uploadFile(el) {
		var self = this,
		    $el = jQuery(el),
		    mime = $el.attr('data-mime_type') || '',
		    ext = $el.attr('data-ext') || false,
		    name = $el.attr('id');
		// If the media frame already exists, reopen it.
		if ('undefined' !== typeof self.fileFrame[name]) {
			if (ext) {
				self.setUploadParams(ext, name);
			}

			self.fileFrame[name].open();

			return;
		}

		// Create the media frame.
		self.fileFrame[name] = wp.media({
			library: {
				type: mime.split(',')
			},
			title: $el.data('box_title'),
			button: {
				text: $el.data('box_action')
			},
			multiple: false
		});

		// When an file is selected, run a callback.
		self.fileFrame[name].on('select', function () {
			// We set multiple to false so only get one image from the uploader
			var attachment = self.fileFrame[name].state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			jQuery(self.fileId).val(attachment.id);
			jQuery(self.fileUrl).val(attachment.url);
			self.replaceButtonClass(el);
			self.updatePreview(el);
		});

		// Finally, open the modal
		self.fileFrame[name].open();
		if (ext) {
			self.setUploadParams(ext, name);
		}
	},

	updatePreview: function updatePreview(el) {
		var self = this,
		    $ul = jQuery(el).parent().find('ul'),
		    $li = jQuery('<li>'),
		    showUrlType = jQuery(el).data('preview_anchor') || 'full';

		$ul.html('');

		if (self.hasValue() && 'none' !== showUrlType) {
			var anchor = jQuery(self.fileUrl).val();
			if ('full' !== showUrlType) {
				anchor = anchor.substring(anchor.lastIndexOf('/') + 1);
			}

			$li.html('<a href="' + jQuery(self.fileUrl).val() + '" download>' + anchor + '</a>');
			$ul.append($li);
		}
	},

	setup: function setup() {
		var self = this;
		jQuery(self.selectors.uploadBtn + ', ' + self.selectors.clearBtn).each(function () {
			self.setFields(jQuery(this));
			self.updatePreview(jQuery(this));
			self.setLabels(jQuery(this));
			self.replaceButtonClass(jQuery(this));
		});
	},

	init: function init() {
		var self = this;

		jQuery(document).on('click', self.selectors.uploadBtn, function (event) {
			event.preventDefault();
			self.setFields(jQuery(this));
			self.uploadFile(jQuery(this));
		});

		jQuery(document).on('click', self.selectors.clearBtn, function (event) {
			event.preventDefault();
			self.setFields(jQuery(this));
			jQuery(self.fileUrl).val('');
			jQuery(self.fileId).val('');

			self.updatePreview(jQuery(this));
			self.replaceButtonClass(jQuery(this));
		});

		this.setup();

		jQuery(document).on('onRepeaterNewRow', function () {
			self.setup();
		});
	}
};

/***/ }),

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

module.exports = {
	selectors: {
		add: '.add-repeater-row',
		remove: '.remove-repeater-row',
		toggle: '.toggle-repeater-row',
		close: '.close-repeater-row',
		sort: '.sort-repeater-row',
		table: '.form-table',
		block: '.repeater-block',
		repeaterLabel: '.repeater-title',
		repeaterField: '.elementor-field-repeater'
	},

	counters: [],

	trigger: function trigger(eventName, params) {
		jQuery(document).trigger(eventName, params);
	},

	triggerHandler: function triggerHandler(eventName, params) {
		return jQuery(document).triggerHandler(eventName, params);
	},

	countBlocks: function countBlocks($btn) {
		return $btn.closest(this.selectors.repeaterField).find(this.selectors.block).length || 0;
	},

	add: function add(btn) {
		var self = this,
		    $btn = jQuery(btn),
		    id = $btn.data('template-id'),
		    repeaterBlock;
		if (!self.counters.hasOwnProperty(id)) {
			self.counters[id] = self.countBlocks($btn);
		}
		self.counters[id] += 1;
		repeaterBlock = jQuery('#' + id).html();
		repeaterBlock = self.replaceAll('__counter__', self.counters[id], repeaterBlock);
		$btn.before(repeaterBlock);
		self.trigger('onRepeaterNewRow', [$btn, $btn.prev()]);
	},

	remove: function remove(btn) {
		var self = this;
		jQuery(btn).closest(self.selectors.block).remove();
	},

	toggle: function toggle(btn) {
		var self = this,
		    $btn = jQuery(btn),
		    $table = $btn.closest(self.selectors.block).find(self.selectors.table),
		    $toggleLabel = $btn.closest(self.selectors.block).find(self.selectors.repeaterLabel);

		$table.toggle(0, 'none', function () {
			if ($table.is(':visible')) {
				$table.closest(self.selectors.block).addClass('block-visible');
				self.trigger('onRepeaterToggleVisible', [$btn, $table, $toggleLabel]);
			} else {
				$table.closest(self.selectors.block).removeClass('block-visible');
				self.trigger('onRepeaterToggleHidden', [$btn, $table, $toggleLabel]);
			}
		});

		$toggleLabel.toggle();

		// Update row label
		self.updateRowLabel(btn);
	},

	close: function close(btn) {
		var self = this,
		    $btn = jQuery(btn),
		    $table = $btn.closest(self.selectors.block).find(self.selectors.table),
		    $toggleLabel = $btn.closest(self.selectors.block).find(self.selectors.repeaterLabel);

		$table.closest(self.selectors.block).removeClass('block-visible');
		$table.hide();
		self.trigger('onRepeaterToggleHidden', [$btn, $table, $toggleLabel]);
		$toggleLabel.show();
		self.updateRowLabel(btn);
	},

	updateRowLabel: function updateRowLabel(btn) {
		var self = this,
		    $btn = jQuery(btn),
		    $table = $btn.closest(self.selectors.block).find(self.selectors.table),
		    $toggleLabel = $btn.closest(self.selectors.block).find(self.selectors.repeaterLabel);

		var selector = $toggleLabel.data('selector');
		// For some browsers, `attr` is undefined; for others,  `attr` is false.  Check for both.
		if ((typeof selector === 'undefined' ? 'undefined' : _typeof(selector)) !== ( true ? 'undefined' : undefined) && false !== selector) {
			var value = false,
			    std = $toggleLabel.data('default');

			if ($table.find(selector).length) {
				value = $table.find(selector).val();
			}

			//filter hook
			var computedLabel = self.triggerHandler('repeaterComputedLabel', [$table, $toggleLabel, value]);

			// For some browsers, `attr` is undefined; for others,  `attr` is false.  Check for both.
			if (undefined !== computedLabel && false !== computedLabel) {
				value = computedLabel;
			}

			// Fallback to default row label
			if (undefined === value || false === value) {
				value = std;
			}

			$toggleLabel.html(value);
		}
	},

	replaceAll: function replaceAll(search, replace, string) {
		return string.replace(new RegExp(search, 'g'), replace);
	},

	init: function init() {
		var self = this;
		jQuery(document).on('click', this.selectors.add, function (event) {
			event.preventDefault();
			self.add(jQuery(this), event);
		}).on('click', this.selectors.remove, function (event) {
			event.preventDefault();
			var result = confirm(jQuery(this).data('confirm').toString());
			if (!result) {
				return;
			}
			self.remove(jQuery(this), event);
		}).on('click', this.selectors.toggle, function (event) {
			event.preventDefault();
			event.stopPropagation();
			self.toggle(jQuery(this), event);
		}).on('click', this.selectors.close, function (event) {
			event.preventDefault();
			event.stopPropagation();
			self.close(jQuery(this), event);
		});

		jQuery(this.selectors.toggle).each(function () {
			self.updateRowLabel(jQuery(this));
		});

		this.trigger('onRepeaterLoaded', [this]);
	}
};

/***/ }),

/***/ 64:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var self = this;
	self.cacheElements = function () {
		this.cache = {
			$button: jQuery('#elementor_pro_typekit_validate_button'),
			$kitIdField: jQuery('#elementor_typekit-kit-id'),
			$dataLabelSpan: jQuery('.elementor-pro-typekit-data')
		};
	};
	self.bindEvents = function () {
		this.cache.$button.on('click', function (event) {
			event.preventDefault();
			self.fetchFonts();
		});

		this.cache.$kitIdField.on('change', function () {
			self.setState('clear');
		});
	};
	self.fetchFonts = function () {
		this.setState('loading');
		this.cache.$dataLabelSpan.addClass('hidden');

		var kitID = this.cache.$kitIdField.val();

		if ('' === kitID) {
			this.setState('clear');
			return;
		}

		jQuery.post(ajaxurl, {
			action: 'elementor_pro_admin_fetch_fonts',
			kit_id: kitID,
			_nonce: self.cache.$button.data('nonce')
		}).done(function (data) {
			if (data.success) {
				var template = self.cache.$button.data('found');
				template = template.replace('{{count}}', data.data.count);
				self.cache.$dataLabelSpan.html(template).removeClass('hidden');
				self.setState('success');
			} else {
				self.setState('error');
			}
		}).fail(function () {
			self.setState();
		});
	};
	self.setState = function (type) {
		var classes = ['loading', 'success', 'error'],
		    currentClass,
		    classIndex;

		for (classIndex in classes) {
			currentClass = classes[classIndex];
			if (type === currentClass) {
				this.cache.$button.addClass(currentClass);
			} else {
				this.cache.$button.removeClass(currentClass);
			}
		}
	};
	self.init = function () {
		this.cacheElements();
		this.bindEvents();
	};
	self.init();
};

/***/ }),

/***/ 65:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var AdvancedRoleManager = __webpack_require__(66);
	this.advancedRoleManager = new AdvancedRoleManager();
};

/***/ }),

/***/ 66:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var self = this;
	self.cacheElements = function () {
		this.cache = {
			$checkBox: jQuery('input[name="elementor_exclude_user_roles[]"]'),
			$advanced: jQuery('#elementor_advanced_role_manager')
		};
	};
	self.bindEvents = function () {
		this.cache.$checkBox.on('change', function (event) {
			event.preventDefault();
			self.checkBoxUpdate(jQuery(this));
		});
	};
	self.checkBoxUpdate = function ($element) {
		var role = $element.val();
		if ($element.is(':checked')) {
			self.cache.$advanced.find('div.' + role).addClass('hidden');
		} else {
			self.cache.$advanced.find('div.' + role).removeClass('hidden');
		}
	};
	self.init = function () {
		if (!jQuery('body').hasClass('elementor_page_elementor-role-manager')) {
			return;
		}
		this.cacheElements();
		this.bindEvents();
	};
	self.init();
};

/***/ }),

/***/ 67:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var CreateTemplateDialog = __webpack_require__(68);
	this.createTemplateDialog = new CreateTemplateDialog();
};

/***/ }),

/***/ 68:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var selectors = {
		templateTypeInput: '#elementor-new-template__form__template-type',
		locationWrapper: '#elementor-new-template__form__location__wrapper',
		postTypeWrapper: '#elementor-new-template__form__post-type__wrapper'
	};

	var elements = {
		$templateTypeInput: null,
		$locationWrapper: null,
		$postTypeWrapper: null
	};

	var setElements = function setElements() {
		jQuery.each(selectors, function (key, selector) {
			key = '$' + key;
			elements[key] = elementorNewTemplate.layout.getModal().getElements('content').find(selector);
		});
	};

	var setLocationFieldVisibility = function setLocationFieldVisibility() {
		elements.$locationWrapper.toggle('section' === elements.$templateTypeInput.val());
		elements.$postTypeWrapper.toggle('single' === elements.$templateTypeInput.val());
	};

	var run = function run() {
		setElements();

		setLocationFieldVisibility();

		elements.$templateTypeInput.change(setLocationFieldVisibility);
	};

	this.init = function () {
		if (!window.elementorNewTemplate) {
			return;
		}

		// Make sure the modal has already been initialized
		elementorNewTemplate.layout.getModal();

		run();
	};

	jQuery(setTimeout.bind(window, this.init));
};

/***/ })

/******/ });
//# sourceMappingURL=admin.js.map