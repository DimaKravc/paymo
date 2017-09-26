<?php
/**
 * Paymo documentation functions and definitions
 *
 * @package PAYMO
 * @since 1.0
 */

define('DOCUMENTATION_VERSION', 1.0);

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Remove recent comments style
 */
function recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style',
    ));
}

add_action('widgets_init', 'recent_comments_style');

if (!function_exists('theme_setup')) :
    /**
     * Theme setup
     */
    function theme_setup()
    {
        /**
         * Add feed links
         */
        add_theme_support('automatic-feed-links');

        /**
         * Add title tag
         */
        add_theme_support('title-tag');
    }
endif;
add_action('after_setup_theme', 'theme_setup');

if (!function_exists('theme_mime_types')) :
    /**
     * Allow SVG through WordPress Media Uploader
     */
    function theme_mime_types($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
endif;
add_filter('upload_mimes', 'theme_mime_types');


if (!function_exists('theme_load_scripts')) :
    /**
     * Register and enqueue styles/scripts
     */
    function theme_load_scripts()
    {
        /**
         * Load styles
         */
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), DOCUMENTATION_VERSION);

        /**
         * Load scripts
         */
        wp_enqueue_script('application', get_template_directory_uri() . '/js/application.js', array('jquery'), DOCUMENTATION_VERSION, true);
        wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('application'), DOCUMENTATION_VERSION, true);

        wp_localize_script('main', 'search_ajax', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nonce'),
        ));

        /**
         * Add noscript tag
         */
        echo '<noscript><style>.sidebar-toggle{display:none;}.code-snippet__copy-toggle{display:none}.sidebar{transform:translateX(0)!important;}@media(max-width: 992px){.primary{transform:translateX(300px)!important;}}</style></noscript>';
    }
endif;
add_action('wp_enqueue_scripts', 'theme_load_scripts');

if (!function_exists('user_phone_number')) :
    /**
     * Add user phone field
     */
    function user_phone_number($contactmethods)
    {
        $contactmethods['phone'] = 'Phone';

        return $contactmethods;
    }
endif;
add_filter('user_contactmethods', 'user_phone_number');

if (!function_exists('breadcrumbs')) :
    /**
     * Add breadcrumbs
     */
    function breadcrumbs($theme_location = 'main-menu', $separator = '<span class="separator"></span>')
    {
        $items = wp_get_nav_menu_items($theme_location);

        if ($items) {
            _wp_menu_item_classes_by_context($items); // Set up the class variables, including current-classes

            $crumbs = array();
            $current_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            foreach ($items as $item) {
                if ($item->current_item_ancestor || $item->current) {
                    $item_url = esc_attr($item->url);
                    if ($item->current_item_ancestor || $item_url != $current_url) {
                        $crumbs[] = "<a class='breadcrumbs__item' href=\"{$item->url}\" title=\"{$item->title}\">{$item->title}</a>";
                    } else {
                        $crumbs[] = "<span class='breadcrumbs__item'>{$item->title}</span>";
                    }
                }
            }
            echo '<div class="breadcrumbs">' . implode($separator, $crumbs) . '</div>';
        }
    }
endif;

if (!function_exists('theme_register_sidebars')) :
    /**
     * Register sidebar
     */
    function theme_register_sidebars()
    {
        register_sidebar(
            array(
                'id' => 'main_sidebar',
                'name' => esc_html__('Left Sidebar', 'paymo'),
                'description' => esc_html__('Drag widget', 'paymo'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget__title">',
                'after_title' => '</h3>',
            )
        );
    }
endif;
add_action('widgets_init', 'theme_register_sidebars');

if (!function_exists('theme_widget_menu_walker')) :
    /**
     * Set custom menu walker for sidebar widget menu
     */
    function theme_widget_menu_walker($args)
    {
        return array_merge($args, array(
            'walker' => new paymo_menu_walker(),
        ));
    }
endif;
add_filter('wp_nav_menu_args', 'theme_widget_menu_walker');

if (!function_exists('theme_content_filter')) :
    /**
     * Add .code-snippet wrap to <pre> tag
     */
    function theme_content_filter($content)
    {
        $content = preg_replace_callback('|<pre.*>(.*)</pre>|isU', 'convert_pre_to_code_snippet', $content);
        $content = preg_replace_callback('|<table.*>(.*)</table>|isU', 'add_wrap_to_table', $content);

        return $content;
    }

    function convert_pre_to_code_snippet($matches)
    {
        $return = '<div class="code-snippet">';
        $return .= $matches[0];
        $return .= '<button class="code-snippet__copy-toggle" data-js="copy-code">';
        $return .= '<span class="code-snippet__tooltip">Скопировано в буфер обмена</span>';
        $return .= '</button></div>';

        return $return;
    }

    function add_wrap_to_table($matches)
    {
        $return = '<div class="table"><div class="table__inner">';
        $return .= $matches[0];
        $return .= '</div></div>';

        return $return;
    }
endif;
add_filter('the_content', 'theme_content_filter');

if (!function_exists('bootstrap_classes_tinymce')) :
    /**
     * Setup TinyMCE editor
     *
     * @TODO Add custom class to table
     */
    function bootstrap_classes_tinymce($settings)
    {
//        $styles = array(
//            array(
//                'title' => 'None',
//                'value' => ''
//            ),
//            array(
//                'title' => 'Table',
//                'value' => 'table',
//            ),
//            array(
//                'title' => 'Striped',
//                'value' => 'table table-striped table-hover',
//            ),
//            array(
//                'title' => 'Bordered',
//                'value' => 'table table-bordered table-hover',
//            ),
//        );

        $default_colours = '"000000", "Black",
                      "993300", "Burnt orange",
                      "333300", "Dark olive",
                      "003300", "Dark green",
                      "003366", "Dark azure",
                      "000080", "Navy Blue",
                      "333399", "Indigo",
                      "333333", "Very dark gray",
                      "800000", "Maroon",
                      "FF6600", "Orange",
                      "808000", "Olive",
                      "008000", "Green",
                      "008080", "Teal",
                      "0000FF", "Blue",
                      "666699", "Grayish blue",
                      "808080", "Gray",
                      "FF0000", "Red",
                      "FF9900", "Amber",
                      "99CC00", "Yellow green",
                      "339966", "Sea green",
                      "33CCCC", "Turquoise",
                      "3366FF", "Royal blue",
                      "800080", "Purple",
                      "999999", "Medium gray",
                      "FF00FF", "Magenta",
                      "FFCC00", "Gold",
                      "FFFF00", "Yellow",
                      "00FF00", "Lime",
                      "00FFFF", "Aqua",
                      "00CCFF", "Sky blue",
                      "993366", "Red violet",
                      "FFFFFF", "White",
                      "FF99CC", "Pink",
                      "FFCC99", "Peach",
                      "FFFF99", "Light yellow",
                      "CCFFCC", "Pale green",
                      "CCFFFF", "Pale cyan",
                      "99CCFF", "Light sky blue",
                      "CC99FF", "Plum"';

        $custom_colours = '"00acc1", "PAYMO Color",';

        //$settings['table_class_list'] = json_encode($styles);
        $settings['textcolor_map'] = '[' . $default_colours . ',' . $custom_colours . ']';
        $settings['textcolor_rows'] = 6;

        return $settings;
    }
endif;
add_filter('tiny_mce_before_init', 'bootstrap_classes_tinymce');

if (!function_exists('custom_meta_box_markup')) :
    /**
     * Add custom meta_box to markup
     */
    function custom_meta_box_markup($object)
    {
        wp_nonce_field(basename(__FILE__), "meta-box-nonce");
        $pages = get_pages(array('post_type' => 'page'));

        echo '<select name="meta-box-dropdown">';

        if (!get_post_meta($object->ID, "meta-box-dropdown", true)) {
            echo '<option selected value="">--</option>';
        } else {
            echo '<option value="">--</option>';
        }

        foreach ($pages as $key => $value) {
            if ($value->post_name == 'not-found') continue;
            if ($value->ID != $object->ID) {
                if ($value->ID == get_post_meta($object->ID, "meta-box-dropdown", true)) {
                    echo '<option selected value="' . $value->ID . '">' . $value->post_title . '</option>';
                } else {
                    echo '<option value="' . $value->ID . '">' . $value->post_title . '</option>';
                }
            }
        }

        echo '</select>';
    }
endif;

if (!function_exists('add_custom_meta_box')) :
    /**
     * Add custom meta_box to Edit Pages Screen
     */
    function add_custom_meta_box()
    {
        global $post;
        if (!empty($post)) {
            if ($post->post_name != 'not-found') {
                add_meta_box("demo-meta-box", "Next page", "custom_meta_box_markup", "page", "side", "low", null);
            }
        }
    }
endif;
add_action("add_meta_boxes", "add_custom_meta_box");

if (!function_exists('save_custom_meta_box')) :
    /**
     * Save post action
     */
    function save_custom_meta_box($post_id, $post, $update)
    {
        if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
            return $post_id;

        if (!current_user_can("edit_post", $post_id))
            return $post_id;

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
            return $post_id;

        $slug = "page";
        echo $post->post_type;
        if ($slug != $post->post_type)
            return $post_id;

        $meta_box_dropdown_value = "";

        if (isset($_POST["meta-box-dropdown"])) {
            $meta_box_dropdown_value = $_POST["meta-box-dropdown"];
        }
        update_post_meta($post_id, "meta-box-dropdown", $meta_box_dropdown_value);
    }
endif;
add_action("save_post", "save_custom_meta_box", 10, 3);

if (!function_exists('search_action_callback')):
    /**
     * Add ajax search
     */
    function search_action_callback()
    {
        check_ajax_referer('nonce', 'ajax_nonce');

        $string = $_POST['s'];
        $fromURL = $_POST['location'];

        $query = new WP_Query(array(
            'posts_per_page' => 9,
            'post_type' => 'page',
            's' => $string
        ));

        $result = '';

        if ($query->posts) {
            foreach ($query->posts as $post) {
                $toURL = get_permalink($post->ID);

                if ($fromURL == $toURL) {
                    $result .= '<dl class="search-result__item"><dt>' . $post->post_title . '</dt><dd>' . wp_strip_all_tags(substr($post->post_content, 0, 120)) . '<small class="search-result__current">Текущая страница</small></dd></dl>';
                } else {
                    $result .= '<a href="' . $toURL . '">';
                    $result .= '<dl class="search-result__item"><dt>' . $post->post_title . '</dt><dd>' . wp_strip_all_tags(substr($post->post_content, 0, 120)) . '</dd></dl>';
                    $result .= '</a>';
                }
            }
            echo $result;
        } else {
            echo '<div class="search-result__not-found">Ничего не найдено</div>';
        }

        wp_die();
    }
endif;
add_action('wp_ajax_nopriv_search_action', 'search_action_callback');
add_action('wp_ajax_search_action', 'search_action_callback');

/**
 * Include files
 */
require get_template_directory() . '/inc/tgm/tgm-plugin-registration.php';
require get_template_directory() . '/inc/menu-walker/menu-walker.php';