<?php 

//Nav Menu Add class on LI element
add_filter ( 'nav_menu_css_class', 'laencore_menu_item_class', 10, 4 );
function laencore_menu_item_class ( $classes, $item, $args, $depth ){
  $classes[] = 'nav-item';
  return $classes;
}

//Nav Menu add class on each link (a)
function laencore_add_specific_menu_location_atts( $atts, $item, $args ) {

    if( $args->theme_location == 'header-menu' ) {
      // add the desired attributes:
      $atts['class'] = 'nav-link';
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'laencore_add_specific_menu_location_atts', 10, 3 );

//Add classes dropdown 
//Nav Menu Bootstrap 
class My_Custom_Nav_Walker extends Walker_Nav_Menu {

   function start_lvl(&$output, $depth = 0, $args = array()) {
      $output .= "\n<ul class=\"dropdown-menu\">\n";
   }

   function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
       $item_html = '';
       parent::start_el($item_html, $item, $depth, $args);

       if ( $item->is_dropdown && $depth === 0 ) {
           $item_html = str_replace( '<a', '<a class="dropdown-toggle"', $item_html );
           $item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
       }

       $output .= $item_html;
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
	
        if ( $element->current )
        $element->classes[] = 'active';

        $element->is_dropdown = !empty( $children_elements[$element->ID] );

        if ( $element->is_dropdown ) {
            if ( $depth === 0 ) {
                $element->classes[] = 'dropdown';
            } elseif ( $depth === 1 ) {
      
                $element->classes[] = 'dropdown-submenu';
				
            }
        }

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	
    }
}



/*******NOW CALL THIS CALL LIKE EXAMPLE BELOW******/
wp_nav_menu(array(
 'walker'      => new MyCustomNavWalker,
));
