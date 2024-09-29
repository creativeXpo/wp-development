<?php

/*
 * Plugin Name: Students Movement 2024
 * Plugin URI: https://creativexpo.net/
 * Description: Students Movement 2024 A Comprehensive List For Martyrs, Injured and Missing.
 * Version: 1.0.0
 * Author: Golam Kibria
 * Author URI: https://creativexpo.net/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: movement24
 *
 */

defined('ABSPATH') || die();

// Custom Image Size


add_action('after_setup_theme', 'red_profile_img');

function red_profile_img() {
    add_image_size('red-featured-img', 400, 400, true);
}





/*
* Custom Post Type
*/

function students_movement_post_type()
{
    $labels = array(
        'name'                  => _x('Students Movement', 'Students Movement General Name', 'movement24'),
        'singular_name'         => _x('Students Movement', 'Students Movement Singular Name', 'movement24'),
        'menu_name'             => __('Students Movement', 'movement24'),
        'name_admin_bar'        => __('Students Movement', 'movement24'),
        'archives'              => __('Item Archives', 'movement24'),
        'attributes'            => __('Item Attributes', 'movement24'),
        'parent_item_colon'     => __('Parent Item:', 'movement24'),
        'all_items'             => __('All Items', 'movement24'),
        'add_new_item'          => __('Add New Item', 'movement24'),
        'add_new'               => __('Add New', 'movement24'),
        'new_item'              => __('New Item', 'movement24'),
        'edit_item'             => __('Edit Item', 'movement24'),
        'update_item'           => __('Update Item', 'movement24'),
        'view_item'             => __('View Item', 'movement24'),
        'view_items'            => __('View Items', 'movement24'),
        'search_items'          => __('Search Item', 'movement24'),
        'not_found'             => __('Not found', 'movement24'),
        'not_found_in_trash'    => __('Not found in Trash', 'movement24'),
        'featured_image'        => __('Image', 'movement24'),
        'set_featured_image'    => __('Set image', 'movement24'),
        'remove_featured_image' => __('Remove image', 'movement24'),
        'use_featured_image'    => __('Use as image', 'movement24'),
        'insert_into_item'      => __('Insert into item', 'movement24'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'movement24'),
        'items_list'            => __('Items list', 'movement24'),
        'items_list_navigation' => __('Items list navigation', 'movement24'),
        'filter_items_list'     => __('Filter items list', 'movement24'),
    );

    $args = array(
        'label'                 => __('Students Movement', 'movement24'),
        'description'           => __('Students Movement Description', 'movement24'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail'),
        // 'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'menu_icon'             => 'dashicons-buddicons-buddypress-logo',
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );

    register_post_type('students_movement', $args);
}

add_action('init', 'students_movement_post_type', 0);


function students_movement_2024_taxonomy() {
    $labels = array(
        'name'              => _x('Statuses', 'taxonomy general name', 'movement24'),
        'singular_name'     => _x('Status', 'taxonomy singular name', 'movement24'),
        'search_items'      => __('Search Statuses', 'movement24'),
        'all_items'         => __('All Statuses', 'movement24'),
        'parent_item'       => __('Parent Status', 'movement24'),
        'parent_item_colon' => __('Parent Status:', 'movement24'),
        'edit_item'         => __('Edit Status', 'movement24'),
        'update_item'       => __('Update Status', 'movement24'),
        'add_new_item'      => __('Add New Status', 'movement24'),
        'new_item_name'     => __('New Status Name', 'movement24'),
        'menu_name'         => __('Status', 'movement24'),
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
    );

    register_taxonomy('status', array('students_movement'), $args);
}

add_action('init', 'students_movement_2024_taxonomy', 0);


/*Load Template*/

// Load the single template for students_movement
function sm_load_single_template($single_template) {
    global $post;

    if ($post->post_type == 'students_movement') {
        $template = plugin_dir_path(__FILE__) . 'templates/single-students_movement.php';
        if (file_exists($template)) {
            $single_template = $template;
        }
    }

    return $single_template;
}
add_filter('single_template', 'sm_load_single_template');


function students_movement_status_temp( $template ) {
    if ( is_tax( 'status' ) ) {
        $plugin_template = plugin_dir_path( __FILE__ ) . 'templates/students-movement-status.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'students_movement_status_temp' );



/* Custom Template */

function sm_add_template($templates) {
    $templates['page-view.php'] = 'Page View';
    $templates['submit-data.php'] = 'Submit Data';
    return $templates;
}
add_filter('theme_page_templates', 'sm_add_template');

function my_plugin_load_template($template) {
    global $post;

    if (!$post) {
        return $template;
    }

    $template_name = get_post_meta($post->ID, '_wp_page_template', true);

    if ('page-view.php' === $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/page-view.php';
    }

    // Corrected the template name check here
    if ('submit-data.php' === $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/submit-data.php';
    }

    return $template;
}
add_filter('template_include', 'my_plugin_load_template');



// enqueue_scripts

function my_plugin_enqueue_styles() {

    wp_enqueue_style('students-movement-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}

add_action('wp_enqueue_scripts', 'my_plugin_enqueue_styles');

/*Pagination*/







