<?php
class user_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	  // Copy all the start_el code from source, and modify
	 
        $output .= sprintf( "\n<li class=\"navigation-user__menu-item\"><a class=\"navigation-user__menu-link\" href='%s'%s>%s</a></li>\n",
            $item->url,
            ( $item->object_id === get_the_ID() ) ? ' class="is-active"' : '',
            $item->title
        );
    
	}
  
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	  // Copy all the end_el code from source, and modify
	}
  }


  class Footer_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      // Copy all the start_el code from source, and modify
          $output .= sprintf( "\n<li class=\"footer-nav__item\"><a class=\"footer-nav__link\" href='%s'%s>%s</a></li>\n",
              $item->url,
              ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
              $item->title
          );
      
    }
    
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
      // Copy all the end_el code from source, and modify
    }
    }
  
  
  class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      // Copy all the start_el code from source, and modify
     
          $output .= sprintf( "\n<li class=\"navigation__item\"><a class=\"navigation__link\" href='%s'%s>%s</a></li>\n",
              $item->url,
              ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
              $item->title
          );
      
    }
    
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
      // Copy all the end_el code from source, and modify
    }
    }


    class B4B_Walker extends Walker_Nav_Menu {
    
      // Displays start of an element. E.g '<li> Item Name'
        // @see Walker::start_el()
        function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
          $object = $item->object;
          $type = $item->type;
          $title = $item->title;
          $description = $item->description;
          $permalink = $item->url;
    
          $output .= "<li class='" .  implode(" ", $item->classes) . "'>";
            
          //Add SPAN if no Permalink
          if( $permalink && $permalink != '#' ) {
            $output .= '<a href="' . $permalink . '">';
          } else {
            $output .= '<span>';
          }
           
          $output .= $title;
    
          if( $description != '' && $depth == 0 ) {
            $output .= '<small class="description">' . $description . '</small>';
          }
    
          if( $permalink && $permalink != '#' ) {
            $output .= '</a>';
          } else {
            $output .= '</span>';
          }
        }
    }