<?php
/**
 * Plugin Name: Advanced Custom Fields for WooCommerce - Brand Fields
 * Plugin URI:  https://yourwebsite.com/advanced-custom-fields-woocommerce
 * Description: Adds brand and brand description fields to WooCommerce products.
 * Version:     1.1
 * Author:      Kevin
 * Author URI:  https://yourwebsite.com
 * License:     GPL2
 * Text Domain: acf-woocommerce
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include ACF if it's not already loaded
if( ! class_exists('ACF') ) {
    include_once( plugin_dir_path( __FILE__ ) . 'includes/acf.php' );
}

// Hook to add custom fields to WooCommerce products
add_action('acf/init', 'acf_add_brand_fields_to_woocommerce');

function acf_add_brand_fields_to_woocommerce() {
    // Check if ACF is active and available
    if( function_exists('acf_add_local_field_group') ) {

        // Add a new custom field group for WooCommerce products
        acf_add_local_field_group(array(
            'key' => 'group_woocommerce_brand_fields',
            'title' => 'Product Brand Details',
            'fields' => array(
                array(
                    'key' => 'field_product_brand',
                    'label' => 'Brand',
                    'name' => 'product_brand',
                    'type' => 'text',
                    'instructions' => 'Enter the brand name for this product.',
                    'required' => 1,
                    'default_value' => '',
                    'placeholder' => 'Enter brand name',
                ),
                array(
                    'key' => 'field_product_brand_description',
                    'label' => 'Brand Description',
                    'name' => 'product_brand_description',
                    'type' => 'textarea',
                    'instructions' => 'Enter a short description of the brand.',
                    'required' => 0,
                    'default_value' => '',
                    'placeholder' => 'Enter brand description',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(),
        ));
    }
}

// Display the brand fields on the front-end product page
add_action('woocommerce_single_product_summary', 'display_brand_fields_on_product_page', 25);
function display_brand_fields_on_product_page() {
    global $post;

    // Retrieve custom fields
    $brand = get_field('product_brand', $post->ID);
    $brand_description = get_field('product_brand_description', $post->ID);

    // Display custom fields if they exist
    if ($brand || $brand_description) {
        echo '<div class="product-brand-details">';
        
        if ($brand) {
            echo '<p><strong>Brand:</strong> ' . esc_html($brand) . '</p>';
        }

        if ($brand_description) {
            echo '<p><strong>Brand Description:</strong> ' . esc_html($brand_description) . '</p>';
        }

        echo '</div>';
    }
}
?>
