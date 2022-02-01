<?php

require_once "functions_blocks.php";
require_once "inc/fuze_label.php";

add_action('init', 'bvsp_init');
function bvsp_init()
{
    add_theme_support('post-thumbnails', array( 'post', 'page' ));

    //add_theme_support( 'automatic-feed-links' );
    //add_theme_support( 'custom-background' );
    //add_theme_support( 'custom-header' );

    if (WP_ENV === 'development') {
        require_once ABSPATH ."../app/plugins/wp-tracy/vendor/autoload.php";
        $wpPanelsClasses = [
            "WpTracy\\WpPanel",
            "WpTracy\\WpUserPanel",
            "WpTracy\\WpPostPanel",
            //"WpTracy\\WpQueryPanel",
            "WpTracy\\WpQueriedObjectPanel",
            "WpTracy\\WpDbPanel",
            "WpTracy\\WpRolesPanel",
            "WpTracy\\WpRewritePanel",
            "WpTracy\\WpCurrentScreenPanel",
        ]; // in the correct order

        // panels registration
        foreach ($wpPanelsClasses as $className) {
            $panel = new $className;
            if ($panel instanceof Tracy\IBarPanel) {
                Tracy\Debugger::getBar()->addPanel(new $className);
            }
        }
    }
}

 
add_filter('acf/settings/save_json', 'acf_json_save_point');
function acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;  
}

add_action('acf/init', 'bvsp_acf_int');
function bvsp_acf_int()
{
    acf_update_setting('google_api_key', 'AIzaSyCDKhQPCFJIHjeHR2z5DwmCiZOPV5V7uwQ');
}

add_action('wp_enqueue_scripts', 'bvsp_assets');
function bvsp_assets()
{
    wp_enqueue_style('bvsp-style', get_template_directory_uri() . '/dist/app.css', array(), 1, 'all');
    wp_enqueue_script('bvsp-script', get_template_directory_uri() . '/dist/app.js', array (), 1, true);
}

add_action('init', 'bvsp_head_cleanup');
function bvsp_head_cleanup()
{
    if (! is_admin()) {
        wp_deregister_script('jquery');
    }
}

add_action('after_setup_theme', 'register_my_menu');
function register_my_menu()
{
    require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
    register_nav_menus(array(
        'primary' => __('Hlavní menu', 'bvsp')
    ));
}

add_filter('wp_nav_menu_args', 'prefix_modify_nav_menu_args');
function prefix_modify_nav_menu_args($args)
{
    return array_merge($args, array(
        'walker' => new WP_Bootstrap_Navwalker(),
    ));
}

add_action('widgets_init', 'bvsp_widgets_init');
function bvsp_widgets_init()
{

    register_sidebar(array(
        'name'          => __('Hlavní stránka - navigace', 'bvsp'),
        'id'            => 'hp_navigation',
        'before_widget' => '<div class="col-md-4"><div class="menu-list style-red">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ));

    register_sidebar(array(
        'name'          => __('Sekce - Partneři', 'bvsp'),
        'id'            => 'section_partners',
        'before_widget' => '<div class="col">',
        'after_widget'  => '</div>'
    ));

    register_sidebar(array(
        'name'          => __('Patička', 'bvsp'),
        'id'            => 'footer_column_1',
        'before_widget' => '<div class="col-md-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    ));

    register_sidebar(array(
        'name'          => __('Absolutní patička - 1 sloupec', 'bvsp'),
        'id'            => 'absolute_footer_column_1',
        'before_widget' => '',
        'after_widget' => '',
    ));

    register_sidebar(array(
        'name'          => __('Absolutní patička - 2 sloupec', 'bvsp'),
        'id'            => 'absolute_footer_column_2',
        'before_widget' => '',
        'after_widget' => ''
    ));
}

//add_filter('use_block_editor_for_post', '__return_false');

add_filter('wpseo_breadcrumb_separator', 'yoast_breadcrumb_separator', 10, 1);
function yoast_breadcrumb_separator($this_options_breadcrumbs_sep)
{
    return '<i class="fas fa-long-arrow-alt-right"></i>';
};

add_action('init', 'bvsp_facility_init');
function bvsp_facility_init()
{
    $labels = array(
        'name'                  => _x('Areály', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Areál', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Areály', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Areál', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Nový', 'textdomain'),
        'add_new_item'          => __('Přidat', 'textdomain'),
        'new_item'              => __('Nový areál', 'textdomain'),
        'edit_item'             => __('Upravit areál', 'textdomain'),
        'view_item'             => __('Zobrazit areál', 'textdomain'),
        'all_items'             => __('Všechny areály', 'textdomain'),
        'search_items'          => __('Hledat areály', 'textdomain'),
        'parent_item_colon'     => __('Parent Books:', 'textdomain'),
        'not_found'             => __('Žádný areál nenalezen.', 'textdomain'),
        'not_found_in_trash'    => __('No books found in Trash.', 'textdomain'),
        'featured_image'        => _x('Ilustrační fotka areálu', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Nastavit ilustrační fotku', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Odebrat fotku', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Použít jako ilustrační fotku', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'areal' ),
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-admin-multisite',
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type('facility', $args);
}

add_action('init', 'bvsp_training_group_init');
function bvsp_training_group_init()
{
    $labels = array(
        'name'                  => _x('Tréninkové skupiny', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Tréninková skupina', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Tréninkové skupiny', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Tréninková skupiny', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Nová skupina', 'textdomain'),
        'add_new_item'          => __('Přidat', 'textdomain'),
        'new_item'              => __('Nová skupina', 'textdomain'),
        'edit_item'             => __('Upravit skupinu', 'textdomain'),
        'view_item'             => __('Zobrazit skupinu', 'textdomain'),
        'all_items'             => __('Všechny skupiny', 'textdomain'),
        'search_items'          => __('Hledat skupiny', 'textdomain'),
        'parent_item_colon'     => __('Nadřazené skupiny:', 'textdomain'),
        'not_found'             => __('Žádná tréninková skupina nenalezena.', 'textdomain'),
        'not_found_in_trash'    => __('No books found in Trash.', 'textdomain'),
        'featured_image'        => _x('Ilustrační fotka tréninkové skupiny', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Nastavit ilustrační fotku', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Odebrat fotku', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Použít jako ilustrační fotku', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Seznam všech skupin', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Vložit do skupiny', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Nahrát do skupiny', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filtrovat seznam skupin', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Navigace seznamu skupin', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Seznam skupin', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'kategorie' ),
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
    );

    register_post_type('training_group', $args);
}

add_action('init', 'bvsp_member_init');
function bvsp_member_init()
{
    $labels = array(
        'name'                  => _x('Členové týmu', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Člen týmu', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Členové týmu', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Člen týmu', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Nový člen', 'textdomain'),
        'add_new_item'          => __('Přidat', 'textdomain'),
        'new_item'              => __('Nový člen', 'textdomain'),
        'edit_item'             => __('Upravit člena', 'textdomain'),
        'view_item'             => __('Zobrazit členy', 'textdomain'),
        'all_items'             => __('Všichni členové', 'textdomain'),
        'search_items'          => __('Hledat člena', 'textdomain'),
        'parent_item_colon'     => __('Nadřazené skupiny:', 'textdomain'),
        'not_found'             => __('Žádný člen nenalezen.', 'textdomain'),
        'not_found_in_trash'    => __('No books found in Trash.', 'textdomain'),
        'featured_image'        => _x('Fotografie člena', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Nastavit fotografii člena', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Odebrat fotku', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Použít jako fotografii člena', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Seznam všech členů', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Vložit ke členovi', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Nahrát ke členovi', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filtrovat seznam členů', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Navigace seznamu členů', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Seznam členů', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'tym' ),
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-universal-access-alt',
        'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
    );

    $labels_tax = array(
        'name'              => _x( 'Typy pozic', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Typ pozice', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Vyhledat typ pozice', 'textdomain' ),
        'all_items'         => __( 'Všechny typy pozic', 'textdomain' ),
        'parent_item'       => __( 'Nadražený typ', 'textdomain' ),
        'parent_item_colon' => __( 'Nadřazený typ:', 'textdomain' ),
        'not_found'         => __( 'Nebyly nalezny žádné typy pozic.', 'textdomain'),
        'edit_item'         => __( 'Upravit typ pozice', 'textdomain' ),
        'update_item'       => __( 'Aktualizovat typ pozice', 'textdomain' ),
        'add_new_item'      => __( 'Přidat nový typ pozice', 'textdomain' ),
        'new_item_name'     => __( 'Nový název typu pozice', 'textdomain' ),
        'menu_name'         => __( 'Typ pozice', 'textdomain' ),
    );
 
    $args_tax = array(
        'hierarchical'      => true,
        'labels'            => $labels_tax,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'typ' ),
    );
 
    register_post_type('member', $args);
    add_theme_support('post-thumbnails');
    add_post_type_support('member', 'thumbnail');
    register_taxonomy( 'type', array( 'member' ), $args_tax );
}

add_action('init', 'bvsp_blog_init');
function bvsp_blog_init()
{
    $labels = array(
        'name'                  => _x('Blog', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Článek', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Blog', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Článek', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Nový článek', 'textdomain'),
        'add_new_item'          => __('Přidat', 'textdomain'),
        'new_item'              => __('Nový článek', 'textdomain'),
        'edit_item'             => __('Upravit článek', 'textdomain'),
        'view_item'             => __('Zobrazit článek', 'textdomain'),
        'all_items'             => __('Všechny články', 'textdomain'),
        'search_items'          => __('Hledat článek', 'textdomain'),
        'parent_item_colon'     => __('Nadřazené skupiny:', 'textdomain'),
        'not_found'             => __('Žádný článek nenalezen.', 'textdomain'),
        'not_found_in_trash'    => __('No books found in Trash.', 'textdomain'),
        'featured_image'        => _x('Fotografie k článku', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Nastavit fotografii článku', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Odebrat fotku', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Použít jako fotografii článku', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Seznam všech článků', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Vložit ke článku', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Nahrát ke článku', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filtrovat seznam článků', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Navigace seznamu článků', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Seznam článků', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-welcome-write-blog',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'author' )
    );

    $labels_tax_cat = array(
        'name'              => _x( 'Rubriky', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Rubrika', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Vyhledat rubriku', 'textdomain' ),
        'all_items'         => __( 'Všechny rubriky', 'textdomain' ),
        'parent_item'       => __( 'Nadražený typ', 'textdomain' ),
        'parent_item_colon' => __( 'Nadřazený typ:', 'textdomain' ),
        'not_found'         => __( 'Nebyly nalezny žádné rubriky.', 'textdomain'),
        'edit_item'         => __( 'Upravit rubriku', 'textdomain' ),
        'update_item'       => __( 'Aktualizovat rubriku', 'textdomain' ),
        'add_new_item'      => __( 'Přidat novou rubriku', 'textdomain' ),
        'new_item_name'     => __( 'Nový název rubriky', 'textdomain' ),
        'menu_name'         => __( 'Rubriky', 'textdomain' ),
    );
 
    $args_tax_cat = array(
        'hierarchical'      => true,
        'labels'            => $labels_tax_cat,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true
    );

    $labels_tax_tag = array(
        'name'              => _x( 'Štítky', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Štítek', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Vyhledat štítek', 'textdomain' ),
        'all_items'         => __( 'Všechny štítky', 'textdomain' ),
        'parent_item'       => __( 'Nadražený typ', 'textdomain' ),
        'parent_item_colon' => __( 'Nadřazený typ:', 'textdomain' ),
        'not_found'         => __( 'Nebyly nalezny žádné štítky.', 'textdomain'),
        'edit_item'         => __( 'Upravit štítek', 'textdomain' ),
        'update_item'       => __( 'Aktualizovat štítek', 'textdomain' ),
        'add_new_item'      => __( 'Přidat nový štítek', 'textdomain' ),
        'new_item_name'     => __( 'Nový název štítku', 'textdomain' ),
        'menu_name'         => __( 'Štítky', 'textdomain' ),
    );
 
    $args_tax_tag = array(
        'hierarchical'      => false,
        'labels'            => $labels_tax_tag,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true
    );

    register_post_type('blog', $args);
    register_taxonomy( 'rubrika', array( 'blog' ), $args_tax_cat );
    register_taxonomy( 'stitek', array( 'blog' ), $args_tax_tag );
}

add_action('init', 'bvsp_post_taxonomies_init');
function bvsp_post_taxonomies_init()
{
    $labels_tax_facility = array(
        'name'              => _x( 'Areály', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Areál', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Vyhledat areál', 'textdomain' ),
        'all_items'         => __( 'Všechny areály', 'textdomain' ),
        'parent_item'       => __( 'Nadražený typ', 'textdomain' ),
        'parent_item_colon' => __( 'Nadřazený typ:', 'textdomain' ),
        'not_found'         => __( 'Nebyly nalezny žádné areály.', 'textdomain'),
        'edit_item'         => __( 'Upravit areál', 'textdomain' ),
        'update_item'       => __( 'Aktualizovat areál', 'textdomain' ),
        'add_new_item'      => __( 'Přidat nový areál', 'textdomain' ),
        'new_item_name'     => __( 'Nový název areálu', 'textdomain' ),
        'menu_name'         => __( 'Areály', 'textdomain' ),
    );
 
    $args_tax_facility = array(
        'hierarchical'      => false,
        'labels'            => $labels_tax_facility,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true
    );

    register_taxonomy( 'arealy', array( 'post' ), $args_tax_facility );
}


if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Nastavení webu',
        'menu_title'    => 'Nastavení webu',
        'menu_slug'     => 'bvsp-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

add_action('init', 'my_update_acf_license');
function my_update_acf_license()
{
    acf_pro_update_license('MzA1NzBiNTE5OWEyMzQ5YmI1ZGQ2NWJkNmQ4ZWM3MzQzNjQyMjQyZmNmOWRlM2UwMDAxOTdj');
}
