
<?php
/**
 * Plugin Name: WooCommerce Custom Plugin
 * Description: A plugin to add custom fields, remove sections, and override CSS on WooCommerce product pages.
 * Version: 1.0
 * Author: ROOT
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue custom CSS for single product pages
function wc_enqueue_custom_css() {
    if (is_product()) { // Check if on a single product page
        wp_enqueue_style(
            'woocommerce-custom-style',
            plugin_dir_url(_FILE_) . 'css/woocommerce-custom-style.css',
            array(),
            '1.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'wc_enqueue_custom_css');

// Add a custom field in the product data tab
function wc_add_custom_field() {
    woocommerce_wp_text_input(
        array(
            'id'          => '_custom_product_field',
            'label'       => __('Custom Product Field', 'woocommerce'),
            'description' => __('Enter a custom field value.', 'woocommerce'),
            'desc_tip'    => true,
        )
    );
}
add_action('woocommerce_product_options_general_product_data', 'wc_add_custom_field');

// Save the custom field value
function wc_save_custom_field($post_id) {
    $custom_field_value = isset($_POST['_custom_product_field']) ? sanitize_text_field($_POST['_custom_product_field']) : '';
    update_post_meta($post_id, '_custom_product_field', $custom_field_value);
}
add_action('woocommerce_process_product_meta', 'wc_save_custom_field');

// Display the custom field on the product page
function wc_display_custom_field() {
    global $product;
    $custom_field_value = get_post_meta($product->get_id(), '_custom_product_field', true);

    if (!empty($custom_field_value)) {
        echo '<p class="custom-product-field">Custom Field: ' . esc_html($custom_field_value) . '</p>';
    }
}
add_action('woocommerce_single_product_summary', 'wc_display_custom_field', 25);