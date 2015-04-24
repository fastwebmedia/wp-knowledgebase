<?php
/*
============
    Article Post type
============
*/

add_action('init', 'kbe_articles');
function kbe_articles() {
    
    $kb_slug = 'kbe_knowledgebase';
    $kb_slug = get_option('kbe_plugin_slug');
    
    $labels = array(
        'name'                  => 	__('Knowledgebase', 'kbe'),
        'singular_name'         => 	__('Knowledgebase', 'kbe'),
        'all_items'             => 	__('Articles', 'kbe'),
        'add_new'               => 	__('New Article', 'kbe'),
        'add_new_item'          => 	__('Add New Article', 'kbe'),
        'edit_item'             => 	__('Edit Article', 'kbe'),
        'new_item'              => 	__('New Article', 'kbe'),
        'view_item'             => 	__('View Articles', 'kbe'),
        'search_items'          => 	__('Search Articles', 'kbe'),
        'not_found'             => 	__('Nothing found', 'kbe'),
        'not_found_in_trash'    => 	__('Nothing found in Trash', 'kbe'),
        'parent_item_colon'     => 	''
    );
    
    $kbe_rewrite = array(
        'slug'        	=> 	KBE_PLUGIN_SLUG,
        'with_front'    => 	true,
        'pages'         => 	false,
        'feeds'         => 	true,
    );
    
    $args = array(
        'labels'                => 	$labels,
        'public'                => 	true,
        'publicly_queryable'    => 	true,
        'show_ui'               => 	true,
        'query_var'             => 	true,
        'menu_icon'             => 	WP_KNOWLEDGEBASE.'images/icon-kbe.png',
        'capability_type'       => 	'post',
        'hierarchical'          => 	false,
        'menu_position'         => 	3,
        'supports'              => 	array('title','editor','thumbnail','comments','tags'),
        'rewrite'               => 	$kbe_rewrite,
        'show_in_menu'          => 	true,
        'show_in_nav_menus'     => 	true,
        'show_in_admin_bar'     => 	true,
        'can_export'            => 	true,
        'has_archive'           => 	true,
        'exclude_from_search'   => 	true
    );
 
    register_post_type( 'kbe_knowledgebase' , $args );
    flush_rewrite_rules();
}
add_action( 'init', 'kbe_taxonomies', 0 );

// Article taxonamy
function kbe_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => 	__( KBE_TITLE. ' Category', 'kbe'),
        'singular_name'     => 	__( KBE_TITLE. ' Category', 'kbe' ),
        'search_items'      => 	__( 'Search '.KBE_TITLE.' Category', 'kbe' ),
        'all_items'         => 	__( 'All '.KBE_TITLE.' Categories', 'kbe' ),
        'parent_item'       => 	__( 'Parent '.KBE_TITLE.' Category', 'kbe' ),
        'parent_item_colon' => 	__( 'Parent '.KBE_TITLE.' Category:', 'kbe' ),
        'edit_item'         => 	__( 'Edit '.KBE_TITLE.' Category', 'kbe' ),
        'update_item'       => 	__( 'Update '.KBE_TITLE.' Category', 'kbe' ),
        'add_new_item'      => 	__( 'Add New '.KBE_TITLE.' Category', 'kbe' ),
        'new_item_name'     => 	__( 'New '.KBE_TITLE.' Category Name', 'kbe' ),
	'menu_name'         => 	__( 'Categories', 'kbe' )
    ); 	
	
    register_taxonomy( 'kbe_taxonomy', array( 'kbe_knowledgebase' ), array(
        'hierarchical'      => 	true,
        "labels"            => 	$labels,
        "singular_label"    => 	__( KBE_TITLE . ' Category', 'kbe'),
        'show_ui'           => 	true,
        'query_var'         => 	true,
        'rewrite'           => 	array( 'slug' => 'support-category', 'with_front' => true )
    ));
    flush_rewrite_rules();
}

add_action( 'init', 'kbe_custom_tags', 0 );
function kbe_custom_tags() {
	
    $labels = array(
                    'name' 		=>  __( KBE_TITLE. ' Tags', 'kbe' ),
                    'singular_name' 	=>  __( KBE_TITLE.' Tag', 'kbe' ),
                    'search_items' 	=>  __( 'Search '.KBE_TITLE.' Tags', 'kbe' ),
                    'all_items' 	=>  __( 'All '.KBE_TITLE.' Tags', 'kbe' ),
                    'edit_item' 	=>  __( 'Edit '.KBE_TITLE.' Tag', 'kbe' ),
                    'update_item' 	=>  __( 'Update '.KBE_TITLE.' Tag', 'kbe' ),
                    'add_new_item' 	=>  __( 'Add New '.KBE_TITLE.' Tag', 'kbe' ),
                    'new_item_name' 	=>  __( 'New '.KBE_TITLE.' Tag Name', 'kbe' ),
                    'menu_name' 	=>  __( 'Tags', 'kbe' )
            );

    register_taxonomy( 'kbe_tags',
                        array('kbe_knowledgebase'),
                        array(
                            'hierarchical'  =>  false,
                            'labels'        =>  $labels,
                            'show_ui'       =>  true,
                            'query_var'     =>  true,
                            'rewrite'       =>  array('slug' => 'support-tags', 'with_front' => true),
                        )
    );
    flush_rewrite_rules();
}

function kbe_set_post_views($postID) {
    $count_key = 'kbe_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
	
    if($count==''){
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
function kbe_get_post_views($postID){
    $count_key = 'kbe_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
	
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
        return "1 View";
    }
    return $count.' Views';
}
add_filter("manage_edit-kbe_knowledgebase_columns", "kbe_edit_columns");     
function kbe_edit_columns($columns){
    $columns = array(  
        "cb" 		=> 	"<input type=\"checkbox\" />", 
        "title" 	=> 	__("Title", "kbe"),
        "author" 	=> 	__("Author", "kbe"),
        "cat" 		=> 	__("Cateogry", "kbe"),
        "tag" 		=> 	__("Tags", "kbe"),
        "comment" 	=> 	__("Comments", "kbe"),
        'views' 	=> 	__("Views", "kbe"),
        "date" 		=> 	__("Date", "kbe")
    );
    return $columns;  
}    
  
add_action("manage_posts_custom_column",  "kbe_custom_columns");   
function kbe_custom_columns($column){
    global $post;  
    switch ($column){ 
        case "title":         
            the_title();
        break; 
        case "author":         
            the_author();
        break;
        case "cat":         
            echo get_the_term_list( $post->ID, 'kbe_taxonomy' , ' ' , ', ' , '' );
        break;
        case "tag":         
            echo get_the_term_list( $post->ID, 'kbe_tags' , ' ' , ', ' , '' );
        break;
        case "comment":         
            comments_number( __('No Comments','kbe'), __('1 Comment','kbe'), __('% Comments','kbe') );
        break;
        case "views":
            $views = get_post_meta($post->ID, 'kbe_post_views_count', true);
            if($views){
                echo $views .__(' Views', 'kbe');
            }else{
                echo __('No Views', 'kbe');
            }
        break;
        case "date":         
            the_date();
        break;
    }
}
?>