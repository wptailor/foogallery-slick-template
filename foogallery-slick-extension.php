<?php
/**
 * FooGallery Slick Extension
 *
 * FooGallery template for Slick carousel
 *
 * @package   FooGallery_Slick_Template_FooGallery_Extension
 * @author     WPTailor
 * @license   GPL-2.0+
 * @link      https://github.com/wptailor
 * @copyright 2014  WPTailor
 *
 * @wordpress-plugin
 * Plugin Name: FooGallery - FooGallery Slick
 * Description: FooGallery template for Slick carousel
 * Version:     1.0.0
 * Author:       WPTailor
 * Author URI:  https://github.com/wptailor
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !class_exists( 'FooGallery_Slick_Template_FooGallery_Extension' ) ) {

    define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_FILE', __FILE__ );
    define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_URL', plugin_dir_url( __FILE__ ));
    define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_VERSION', '1.0.0');
    define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_PATH', plugin_dir_path( __FILE__ ));
    define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_SLUG', 'foogallery-slick');
    //define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL', 'http://fooplugins.com');
    //define('FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME', 'FooGallery Slick');

    require_once( 'foogallery-slick-init.php' );

    class FooGallery_Slick_Template_FooGallery_Extension {

        public $slick_options = [
            'accessibility',
            'adaptiveHeight',
            'arrows',
            'asNavFor',
            'prevArrow',
            'nextArrow',
            'autoplay',
            'autoplaySpeed',
            'centerMode',
            'centerPadding',
            'cssEase',
            'dots',
            'dotsClass',
            'draggable',
            'easing',
            'edgeFriction',
            'fade',
            'focusOnSelect',
            'infinite',
            'initialSlide',
            'lazyLoad',
            'mobileFirst',
            'pauseOnHover',
            'pauseOnFocus',
            'pauseOnDotsHover',
            'respondTo',
            'responsive',
            'rows',
            'rtl',
            'slide',
            'slidesPerRow',
            'slidesToShow',
            'slidesToScroll',
            'speed',
            'swipe',
            'swipeToSlide',
            'touchMove',
            'touchThreshold',
            'useCSS',
            'useTransform',
            'variableWidth',
            'vertical',
            'verticalSwiping',
            'waitForAnimate',
            'zIndex',
        ];

        public function prepare_value_for_js( $value ) {

            if ( is_numeric( $value ) ) {
                $prep = intval( $value );
            }
            else {
                switch ( $value ) {
                    case 'on':
                        $value = true;
                        break;
                    case 'off':
                        $value = false;
                        break;
                    default:
                        $prep = $value;
                }
            }

            return $value;
        }

        /**
         * Wire up everything we need to run the extension
         */
        function __construct() {
            add_filter( 'foogallery_gallery_templates', [ $this, 'add_template' ] );
            add_filter( 'foogallery_gallery_templates_files', [ $this, 'register_myself' ] );
            add_filter( 'foogallery_located_template-foogallery-slick', [ $this, 'enqueue_dependencies' ] );
            add_filter( 'foogallery_located_template-foogallery-slick-slider-sync', [ $this, 'enqueue_dependencies' ] );
            add_filter( 'foogallery_template_js_ver-foogallery-slick', [ $this, 'override_version' ] );
            add_filter( 'foogallery_template_css_ver-foogallery-slick', [ $this, 'override_version' ] );

            add_filter( 'foogallery_attachment_html_link_attributes', [$this, 'attachment_html_link_attributes'], 10, 3 );

            //used for auto updates and licensing in premium extensions. Delete if not applicable
            //init licensing and update checking
            //require_once( FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_PATH . 'includes/EDD_SL_FooGallery.php' );

            //new EDD_SL_FooGallery_v1_1(
            //  FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_FILE,
            //  FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_SLUG,
            //  FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_VERSION,
            //  FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL,
            //  FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME,
            //  'FooGallery Slick');
        }

        /**
         * Register myself so that all associated JS and CSS files can be found and automatically included
         * @param $extensions
         *
         * @return array
         */
        function register_myself( $extensions ) {
            $extensions[] = __FILE__;
            return $extensions;
        }

        /**
         * Override the asset version number when enqueueing extension assets
         */
        function override_version( $version ) {
            return FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_VERSION;
        }

        /**
         * Enqueue any script or stylesheet file dependencies that your gallery template relies on
         */
        function enqueue_dependencies() {
            $js = '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js';
            wp_enqueue_script( 'foogallery-slick', $js, ['jquery'], '1.6.0' );

            $css = '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css';
            foogallery_enqueue_style( 'foogallery-slick', $css, [], '1.6.0' );
        }

        public function attachment_html_link_attributes( $attr, $args, $attachment ) {
            global $current_foogallery_template;

            if ( 'foogallery-slick-slider-sync' === $current_foogallery_template ) {
                if ( ( isset( $args['resize'] ) && true === $args['resize'] ) && '1' === $args['crop'] ) {
                    $style = ! empty( $attr['style'] ) ? $attr['style'] . ' ' : '';
                    $style .= sprintf( 'width: %1$dpx; height: %2$dpx; display: block;', $args['width'], $args['height'] );
                    $attr['style'] = $style;
                }
            }

            return $attr;
        }

        public function settings_fields( $type = '' ) {
            $fields = [];

            $fields = array_merge( $fields, [
                [
                    'id'      => 'thumbnail_size',
                    'title'   => __('Thumbnail Size', 'foogallery-slick'),
                    'desc'    => __('Choose the size of your thumbs.', 'foogallery-slick'),
                    'type'    => 'thumb_size',
                    'default' => [
                        'width' => get_option( 'thumbnail_size_w' ),
                        'height' => get_option( 'thumbnail_size_h' ),
                        'crop' => true
                    ],
                ],
                [
                    'id'      => 'thumbnail_link',
                    'title'   => __('Thumbnail Link', 'foogallery-slick'),
                    'default' => 'image' ,
                    'type'    => 'thumb_link',
                    'spacer'  => '<span class="spacer"></span>',
                    'desc'    => __('You can choose to either link each thumbnail to the full size image or to the image\'s attachment page.', 'foogallery-slick')
                ],
                [
                    'id'      => 'lightbox',
                    'title'   => __('Lightbox', 'foogallery-slick'),
                    'desc'    => __('Choose which lightbox you want to use in the gallery.', 'foogallery-slick'),
                    'type'    => 'lightbox'
                ],
                [
                    'id'      => 'alignment',
                    'title'   => __('Gallery Alignment', 'foogallery-slick'),
                    'desc'    => __('The horizontal alignment of the thumbnails inside the gallery.', 'foogallery-slick'),
                    'default' => 'alignment-center',
                    'type'    => 'select',
                    'choices' => [
                        'alignment-left' => __( 'Left', 'foogallery-slick' ),
                        'alignment-center' => __( 'Center', 'foogallery-slick' ),
                        'alignment-right' => __( 'Right', 'foogallery-slick' )
                    ],
                ],
            ] );

            if ( 'slider-sync' === $type ) {
                $fields = array_merge( $fields, [
                    [
                        'id'      => 'main_thumbnail_size',
                        'title'   => __('Large Image Size', 'foogallery-slick'),
                        'desc'    => __('Choose the size of your large image.', 'foogallery-slick'),
                        'type'    => 'thumb_size',
                        'default' => [
                            'width' => get_option( 'large_size_w' ),
                            'height' => get_option( 'large_size_h' ),
                            'crop' => true
                        ],
                        'section' => __( 'Main Slider' ),
                    ],
                ] );
            }

            /**
             * Slick options
             */
            $fields = array_merge( $fields, [
                [
                    'id'      => 'autoplay',
                    'title'   => __( 'Autoplay', 'foogallery-slick' ),
                    'desc'    => __( 'Enables Autoplay', 'foogallery-slick' ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'section' => __( 'Slick Settings', 'foogallery-slick' ),
                ],
                [
                    'id'      => 'autoplaySpeed',
                    'title'   => __('Autoplay Speed', 'foogallery-slick'),
                    'desc'    => __('Autoplay Speed in milliseconds', 'foogallery-slick'),
                    'default' => 3000,
                    'type'    => 'text',
                    'section' => __( 'Slick Settings', 'foogallery-slick' ),
                ],
                [
                    'id'      => 'dots',
                    'title'   => __( 'Dots indicators', 'foogallery-slick' ),
                    'desc'    => __( 'Show dot indicators', 'foogallery-slick' ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                    'section' => __( 'Slick Settings', 'foogallery-slick' ),
                ],
                [
                    'id'      => 'infinite',
                    'title'   => __( 'Infinite', 'foogallery-slick' ),
                    'desc'    => __( 'Infinite loop sliding', 'foogallery-slick' ),
                    'type'    => 'checkbox',
                    'section' => __( 'Slick Settings', 'foogallery-slick' ),
                ],
                [
                    'id'      => 'slidesToShow',
                    'title'   => __('Slides to show', 'foogallery-slick'),
                    'desc'    => __('Number of slides to show', 'foogallery-slick'),
                    'default' => 1,
                    'type'    => 'text',
                    'section' => __( 'Slick Settings', 'foogallery-slick' ),
                ],
                [
                    'id'      => 'slidesToScroll',
                    'title'   => __('Slides to scroll', 'foogallery-slick'),
                    'desc'    => __('Number of slides to scroll'),
                    'default' => 1,
                    'type'    => 'text',
                    'section' => __( 'Slick Settings', 'foogallery-slick' ),
                ]
            ] );

            return $fields;
        }

        /**
         * Add our gallery template to the list of templates available for every gallery
         * @param $gallery_templates
         *
         * @return array
         */
        function add_template( $gallery_templates ) {

            $gallery_templates[] = [
                'slug'        => 'foogallery-slick',
                'name'        => __( 'FooGallery Slick', 'foogallery-slick'),
                'preview_css' => FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/gallery-foogallery-slick.css',
                'admin_js'    => FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/admin-gallery-foogallery-slick.js',
                'fields'      => $this->settings_fields(),
                    // [
                    //available field types available : html, checkbox, select, radio, textarea, text, checkboxlist, icon
                    //an example of a icon field used in the default gallery template
                    //[
                    //  'id'      => 'border-style',
                    //  'title'   => __('Border Style', 'foogallery-slick'),
                    //  'desc'    => __('The border style for each thumbnail in the gallery.', 'foogallery-slick'),
                    //  'type'    => 'icon',
                    //  'default' => 'border-style-square-white',
                    //  'choices' => [
                    //      'border-style-square-white' => ['label' => 'Square white border with shadow', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-white.png'),
                    //      'border-style-circle-white' => ['label' => 'Circular white border with shadow', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-circle-white.png'),
                    //      'border-style-square-black' => ['label' => 'Square Black', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-black.png'),
                    //      'border-style-circle-black' => ['label' => 'Circular Black', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-circle-black.png'),
                    //      'border-style-inset' => ['label' => 'Square Inset', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-inset.png'),
                    //      'border-style-rounded' => ['label' => 'Plain Rounded', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-plain-rounded.png'),
                    //      '' => ['label' => 'Plain', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-none.png'),
                    //  )
                    //),
                // )
            ];

            $gallery_templates[] = [
                'slug'          => 'foogallery-slick-slider-sync',
                'name'          => __( 'FooGallery Slick Slider Syncing', 'foogallery-slick'),
                'preview_css'   => FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/gallery-foogallery-slick.css',
                'admin_js'      => FOOGALLERY_SLICK_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/admin-gallery-foogallery-slick.js',
                'fields'        => $this->settings_fields('slider-sync'),
            ];

            return $gallery_templates;
        }
    }
}
