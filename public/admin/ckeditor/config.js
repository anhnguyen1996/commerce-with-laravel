/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.filebrowserBrowseUrl =  window.location.protocol + '//' + window.location.hostname + '/mvc/public/assets/admin/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl =  window.location.protocol + '//' + window.location.host + '/mvc/public/assets/admin/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl =  window.location.protocol + '//' + window.location.host + '/mvc/public/assets/admin/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl =  window.location.protocol + '//' + window.location.host + '/mvc/public/assets/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = window.location.protocol + '//' + window.location.host + '/mvc/public/assets/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = window.location.protocol + '//' + window.location.host + '/mvc/public/assets/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
