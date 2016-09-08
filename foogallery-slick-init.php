<?php
//This init class is used to add the extension to the extensions list while you are developing them.
//When the extension is added to the supported list of extensions, this file is no longer needed.

if ( !class_exists( 'FooGallery_Slick_Template_FooGallery_Extension_Init' ) ) {
	class FooGallery_Slick_Template_FooGallery_Extension_Init {

		function __construct() {
			add_filter( 'foogallery_available_extensions', array( $this, 'add_to_extensions_list' ) );
		}

		function add_to_extensions_list( $extensions ) {
			$extensions[] = array(
				'slug'=> 'foogallery-slick',
				'class'=> 'FooGallery_Slick_Template_FooGallery_Extension',
				'title'=> __('FooGallery Slick', 'foogallery-slick'),
				'file'=> 'foogallery-slick-extension.php',
				'description'=> __('FooGallery template for Slick carousel', 'foogallery-slick'),
				'author'=> ' WPTailor',
				'author_url'=> 'https://github.com/wptailor',
				'thumbnail'=> FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_URL . '/assets/extension_bg.png',
				'tags'=> array( __('template', 'foogallery') ),	//use foogallery translations
				'categories'=> array( __('Build Your Own', 'foogallery') ), //use foogallery translations
				'source'=> 'generated'
			);

			return $extensions;
		}
	}


	new FooGallery_Slick_Template_FooGallery_Extension_Init();
}
