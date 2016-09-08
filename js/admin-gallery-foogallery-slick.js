//Use this file to inject custom javascript behaviour into the foogallery edit page
//For an example usage, check out wp-content/foogallery/extensions/default-templates/js/admin-gallery-default.js

(function (FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION, $, undefined) {

	FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION.doSomething = function() {
		//do something when the gallery template is changed to foogallery-slick
	};

	FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION.adminReady = function () {
		$('body').on('foogallery-gallery-template-changed-foogallery-slick', function() {
			FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION.doSomething();
		});
	};

}(window.FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION = window.FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION || {}, jQuery));

jQuery(function () {
	FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION.adminReady();
});