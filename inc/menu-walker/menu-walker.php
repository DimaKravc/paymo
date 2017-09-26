<?php

class paymo_menu_walker extends Walker_Nav_Menu
    /**
     * @see Walker::start_el()
     * @since 1.0
     *
     * @param string $output
     * @param object $item
     * @param int $depth
     * @param object $args
     */
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $class_names = join(' ', $item->classes);
        $class_names = ' class="depth-' . ($depth + 1) . esc_attr($class_names) . '"';
        $output .= '<li id="menu-item-' . $item->ID . '"' . $class_names . '>';

        $attributes = !empty($item->url) ? ' href="' . esc_attr($item->url) . '" class="menu-item__inner"' : '';
        $item_output = $args->before;

        $current_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $item_url = esc_attr($item->url);
        if ($item_url != $current_url && !stripos($class_names, 'current-menu-ancestor')) $item_output .= '<a' . $attributes . '>' . $item->title . '</a>';
        else $item_output .= '<span class="menu-item__inner">' . $item->title . '</span>';

        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

?>
