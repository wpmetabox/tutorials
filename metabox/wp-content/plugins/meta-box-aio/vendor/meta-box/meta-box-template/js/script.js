/**
 * Turn plugin textarea for template input into an editor that supports basic functionality of an code editor
 * such as tab, auto indent, etc.
 *
 * As this Javascript file is loaded in footer, we don't need to use DOM ready event (and we don't use jQuery at all!).
 */
(function ()
{
	var editor = new Behave( {
		textarea: document.getElementById( 'meta-box-template' ),
		tabSize : 2,
		autoIndent: true
	} );
})();
