<?php
/**
 * FooGallery FooGallery Slick gallery template
 * This is the template that is run when a FooGallery shortcode is rendered to the frontend
 */

global $foogallery_extensions, $current_foogallery_template, $foogallery_currently_loading;
$extionsion = $foogallery_extensions[ $foogallery_currently_loading ];

//the current FooGallery that is currently being rendered to the frontend
global $current_foogallery;

//the current shortcode args
global $current_foogallery_arguments;

//get our thumbnail sizing args
$args = foogallery_gallery_template_setting( 'thumbnail_size', 'thumbnail' );
$args['link'] = 'none';
//add the link setting to the args
//get which lightbox we want to use
$lightbox = foogallery_gallery_template_setting( 'lightbox', 'unknown' );

$args_main = foogallery_gallery_template_setting( 'main_thumbnail_size' );
$args_main['resize'] = true;
$args_main['link'] = foogallery_gallery_template_setting( 'thumbnail_link', 'image' );

$data_slick = [];

foreach ( $extionsion->slick_options as $js_option ) {
    $setting = foogallery_gallery_template_setting( $js_option, null );
    if ( ! is_null( $setting ) ) {
        $data_slick[$js_option] = $extionsion->prepare_value_for_js( $setting );
    }
}

$data_slick['asNavFor'] = sprintf('#foogallery-gallery-main-%d', $current_foogallery->ID );
$data_slick['focusOnSelect'] = true;

$data_main_slick = [
    'slidesToShow' => 1,
    'slidesToScroll' => 1,
    'arrows' => false,
    'fade' => true,
    'asNavFor' => sprintf('#foogallery-gallery-nav-%d', $current_foogallery->ID ),
];

$main_slick = $nav_slick = '';

foreach ( $current_foogallery->attachments() as $att ) : ?>
    <?php ob_start(); ?>
    <div>
        <?php
        echo $att->html( $args_main );

        if ( !empty($att->caption) || !empty($att->description) ) {
            $caption = '<div class="slick-item-caption">';
            if ( !empty($att->caption) ) {
                $caption .= '<h4>' . $att->caption . '</h4>';
            }
            if ( !empty($att->description) ) {
                $caption .= '<p>' . $att->description . '</p>';
            }
            $caption .= '</div>';
        }
        ?>
    </div>
    <?php
    $main_slick .= ob_get_clean();
    ob_start();
    ?>
    <div><?= $att->html( $args ) ?></div>
    <?php $nav_slick .= ob_get_clean(); ?>
<?php endforeach; ?>
<div id="foogallery-gallery-<?php echo $current_foogallery->ID; ?>" class="foogallery-gallery-wrap">
    <div id="foogallery-gallery-main-<?php echo $current_foogallery->ID; ?>" class="<?php foogallery_build_class_attribute_render_safe( $current_foogallery, 'foogallery-lightbox-' . $lightbox, 'foogallery-foogallery-slick-main' ); ?>" data-slick='<?= esc_attr( json_encode( apply_filters( 'foogallery-template-slick-data-attr', $data_main_slick, 'slider-sync-main' ), JSON_NUMERIC_CHECK ) ); ?>'>
        <?= $main_slick; ?>
    </div>

    <div id="foogallery-gallery-nav-<?php echo $current_foogallery->ID; ?>" class="<?php foogallery_build_class_attribute_render_safe( $current_foogallery, 'foogallery-foogallery-slick-nav' ); ?>" data-slick='<?= esc_attr( json_encode( apply_filters( 'foogallery-template-slick-data-attr', $data_slick, 'slider-sync-nav' ), JSON_NUMERIC_CHECK ) ); ?>'>
        <?= $nav_slick; ?>
    </div>
</div>
