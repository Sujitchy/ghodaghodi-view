<?php
/**
 * Custom Nav Walker to apply Tailwind CSS classes to WordPress menus
 */

class Ghodaghodi_Walker_Nav extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent  = str_repeat("\t", $depth);
        $classes = 'submenu absolute left-0 top-full bg-emerald-800 shadow-lg rounded-b-lg py-2 min-w-[200px] hidden group-hover:block';
        $output .= "\n$indent<ul class=\"" . $classes . "\">\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes   = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';
        $classes[] = 'relative';
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'group';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts           = [];
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        $link_classes = 'block py-2 md:py-0 hover:text-amber-400 transition';
        if ($depth > 0) {
            $link_classes = 'block px-4 py-2 hover:bg-emerald-700 hover:text-amber-400 transition text-sm';
        }
        $atts['class'] = $link_classes;

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output  = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;

        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= ' <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
