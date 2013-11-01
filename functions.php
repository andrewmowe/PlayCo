<?php

add_action( 'after_setup_theme', 't8_setup' );

if ( ! function_exists( 't8_setup' ) ):
function t8_setup() {

	add_theme_support( 'post-thumbnails' );
	
/** 
 * Collects our theme options 
 * 
 * @return array 
 */  
function t8_get_global_options(){  
      
    $t8_option = array();  
  
    // collect option names as declared in wptuts_get_settings()  
    $t8_option_names = array (  
        't8_options_two_plays_pages',
        't8_options_two_footer' 
    );  
  
    // loop for get_option  
    foreach ($t8_option_names as $t8_option_name) {  
        if (get_option($t8_option_name)!= FALSE) {  
            $option     = get_option($t8_option_name);  
              
            // now merge in main $wptuts_option array!  
            $t8_option = array_merge($t8_option, $option);  
        }  
    }     
      
return $t8_option;  
}
$t8_option = t8_get_global_options();

	// WPTuts WP Options require only in admin!
	if(is_admin()){	
		require_once('lib/t8-theme-settings-advanced.php');
	}
} endif; // t8_setup

function add_theme_caps() {
    // gets the author role
    $role = get_role( 'editor' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'manage_options' ); 
}
add_action( 'admin_init', 'add_theme_caps');



//*********************
//PLAYS POST TYPE ////
//*********************

register_taxonomy("regions", 
	array("post","plays"), 
	array("hierarchical" => true, 
		"label" => "Regions", 
		"singular_label" => "Region",
		"add_new_item" => "Add New Region",
		'rewrite' => array( 'slug' => 'regions' )
	)
);
register_taxonomy("seasons", 
	array("plays"), 
	array("hierarchical" => true, 
		"label" => "Seasons", 
		"singular_label" => "Season",  
		'rewrite' => array( 'slug' => 'seasons' )
	)
);

// play posttype 
add_action( 'init', 'create_plays' );
function create_plays() {
  $labels = array(
    'name' => _x('Plays', 'post type general name'),
    'singular_name' => _x('Play', 'post type singular name'),
    'add_new' => _x('Add New', 'Play'),
    'add_new_item' => __('Add New Play'),
    'edit_item' => __('Edit Play'),
    'new_item' => __('New Play'),
    'view_item' => __('View Play'),
    'search_items' => __('Search Plays'),
    'not_found' =>  __('No Plays found'),
    'not_found_in_trash' => __('No Plays found in Trash'),
    'parent_item_colon' => ''
  );
  $supports = array('title', 'editor', 'revisions', 'page-attributes', 'thumbnail'); // 'page-attributes' must be set for Simple Page Ordering plugin

  register_post_type( 'plays',
    array(
      'labels' => $labels,
      'public' => true,
      'hierarchical' => false,
      'capability_type' => 'post',
	  'has_archive' => true, //THIS IS CRUCIAL for use with Simple Page Ordering plugin
      'supports' => $supports
	  
    )
  );
  flush_rewrite_rules();
}

//*******************************************
// REMOVE p TAGS FROM IMAGES
//*******************************************

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');


//*******************************************
// WP Nav Menu
//*******************************************

add_filter( 'wp_nav_menu_items', 'add_home_link', 10, 2 );
function add_home_link($items, $args) {
  
 	if($args->theme_location == 'primary') {
        $homeMenuItem =
			'<a class="logo-link md" href="'.get_bloginfo('url').'"><img class="logo-img md" src="'.get_bloginfo('template_directory').'/images/playco_logo_md-232x70.png" alt="The Play Company logo" /></a>'
			.'<a class="logo-link sm" href="'.get_bloginfo('url').'"><img class="logo-img sm" src="'.get_bloginfo('template_directory').'/images/playco_logo_sm-47x30.png" alt="The Play Company logo" /></a>';
  
        $items = $homeMenuItem . $items;
        
	}  
    return $items;
}
 // This theme uses wp_nav_menu() in one locations.
register_nav_menus( array(
	'primary' => __( 'Main Nav' ),
	'mini' => __( 'Mini Nav' )
) );

class select_menu_walker extends Walker_Nav_Menu{
 
	 function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "";
	}
 
 
	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "";
	}
 
	 function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
 
		//check if current page is selected page and add selected value to select element  
		  $selc = '';
		  $curr_class = 'current-menu-item';
		  $is_current = strpos($class_names, $curr_class);
		  if($is_current === false){
	 		  $selc = "";
		  }else{
	 		  $selc = "selected ";
		  }
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
 
		$sel_val =  ' value="'   . esc_attr( $item->url        ) .'"';
 
		//check if the menu is a submenu
		switch ($depth){
		  case 0:
			   $dp = "";
			   break;
		  case 1:
			   $dp = "-";
			   break;
		  case 2:
			   $dp = "--";
			   break;
		  case 3:
			   $dp = "---";
			   break;
		  case 4:
			   $dp = "----";
			   break;
		  default:
			   $dp = "";
		}
 
 
		$output .= $indent . '<option'. $sel_val . $id . $value . $class_names . $selc . '>'.$dp;
 
		$item_output = $args->before;
		//$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//$item_output .= '</a>';
		$item_output .= $args->after;
 
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
 
	function end_el(&$output, $item, $depth) {
		$output .= "</option>\n";
	}
 
}

add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2 );
function current_type_nav_class($classes, $item) {
    $post_type = get_post_type();
    $term = get_query_var('term');
// echo '<pre>';
// print_r($item);
// echo '</pre>';
    if ($item->post_type != '' && $item->post_name == 'archives' && $post_type == 'plays' && $term != 'current-season') {
        array_push($classes, 'current-menu-item');
    };
    if ($item->post_type != '' && $item->post_name == 'our-plays' && $post_type == 'plays') {
        array_push($classes, 'current-menu-ancestor');
    };
    return $classes;
}

//*******************************************
// Play Seasons Admin Columns
//*******************************************
// GET START DATE  
function pc_get_season($post_ID) {  
    $play_seasons = get_the_terms($post_ID, 'seasons');  
    return $play_seasons;
}

// ADD START DATE COLUMN  
function pc_columns_head($defaults) {  
    $defaults['season'] = 'Season';  
    return $defaults;  
}  
  
// SHOW THE START DATE  
function pc_columns_content($column_name, $post_ID) {
    if ($column_name == 'season') {  
        $play_seasons = pc_get_season($post_ID);
        $seasons = array();
        if ($play_seasons) : foreach($play_seasons as $season) {  
            $seasons[] = $season->name;
        } endif;
        echo join(', ', $seasons);
    }
}

add_filter('manage_edit-plays_columns', 'pc_columns_head');  
add_action('manage_posts_custom_column', 'pc_columns_content', 10, 2);

add_filter( 'manage_edit-plays_sortable_columns', 'start_date_sort_column' );
function start_date_sort_column( $columns ) {  
    $columns['season'] = 'season';  
    return $columns;  
}

//*******************************************
// ADD IMAGE SIZES
//*******************************************

add_image_size( 'gallery', 696, 522 );
add_image_size( 'archive', 328, 228, true );