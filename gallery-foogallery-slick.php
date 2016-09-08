<?php
/**
 * FooGallery FooGallery Slick gallery template
 * This is the template that is run when a FooGallery shortcode is rendered to the frontend
 */

global $foogallery_extensions, $current_foogallery_template;
$extionsion = $foogallery_extensions[ $current_foogallery_template ];

//the current FooGallery that is currently being rendered to the frontend
global $current_foogallery;

//the current shortcode args
global $current_foogallery_arguments;

//get our thumbnail sizing args
$args = foogallery_gallery_template_setting( 'thumbnail_size', 'thumbnail' );
//add the link setting to the args
$args['link'] = foogallery_gallery_template_setting( 'thumbnail_link', 'image' );
//get which lightbox we want to use
$lightbox = foogallery_gallery_template_setting( 'lightbox', 'unknown' );

$data_slick = [];

foreach ( $extionsion->slick_options as $js_option ) {
    $setting = foogallery_gallery_template_setting( $js_option, null );
    if ( ! is_null( $setting ) ) {
        $data_slick[$js_option] = $extionsion->prepare_value_for_js( $setting );
    }
}
?>
<ul id="foogallery-gallery-<?php echo $current_foogallery->ID; ?>" class="<?php foogallery_build_class_attribute_render_safe( $current_foogallery, 'foogallery-lightbox-' . $lightbox ); ?>" data-slick='<?= esc_attr( json_encode( $data_slick ) ); ?>'>
	<?php foreach ( $current_foogallery->attachments() as $attachment ) {
		echo '<li>' . $attachment->html( $args ) . '</li>';
	} ?>
</ul>
