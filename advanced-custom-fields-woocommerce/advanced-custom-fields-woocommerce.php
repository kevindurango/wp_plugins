<?php
/**
 * Plugin Name: Advanced Custom Fields for WooCommerce
 * Plugin URI:  https://yourwebsite.com/advanced-custom-fields-woocommerce
 * Description: Adds custom fields to WooCommerce products with more specific and broad field options.
 * Version:     1.0
 * Author:      Your Name
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
add_action('acf/init', 'acf_add_custom_fields_for_woocommerce');

function acf_add_custom_fields_for_woocommerce() {
    // Check if ACF is active and available
    if( function_exists('acf_add_local_field_group') ) {

        // Add a new custom field group for WooCommerce products
        acf_add_local_field_group(array(
            'key' => 'group_woocommerce_product_fields',
            'title' => 'Custom WooCommerce Product Fields',
            'fields' => array(
                array(
                    'key' => 'field_product_custom_text',
                    'label' => 'Custom Product Text',
                    'name' => 'product_custom_text',
                    'type' => 'text',
                    'instructions' => 'Enter custom text for this product.',
                    'required' => 0,
                    'default_value' => '',
                    'placeholder' => 'Enter custom text',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_product_custom_number',
                    'label' => 'Custom Product Number',
                    'name' => 'product_custom_number',
                    'type' => 'number',
                    'instructions' => 'Enter a custom number for this product.',
                    'required' => 0,
                    'default_value' => '',
                    'placeholder' => '',
                    'min' => 1,
                    'max' => 100,
                ),
                array(
                    'key' => 'field_product_custom_select',
                    'label' => 'Custom Product Select',
                    'name' => 'product_custom_select',
                    'type' => 'select',
                    'choices' => array(
                        'option_1' => 'Option 1',
                        'option_2' => 'Option 2',
                        'option_3' => 'Option 3',
                    ),
                    'default_value' => 'option_1',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                // More fields can be added here
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

// Display the custom fields on the front-end product page
add_action('woocommerce_single_product_summary', 'display_custom_fields_on_product_page', 25);
function display_custom_fields_on_product_page() {
    global $post;

    // Check if custom fields exist
    $custom_text = get_field('product_custom_text', $post->ID);
    $custom_number = get_field('product_custom_number', $post->ID);
    $custom_select = get_field('product_custom_select', $post->ID);

    if ($custom_text || $custom_number || $custom_select) {
        echo '<div class="custom-product-fields">';

        if ($custom_text) {
            echo '<p><strong>Custom Text:</strong> ' . esc_html($custom_text) . '</p>';
        }

        if ($custom_number) {
            echo '<p><strong>Custom Number:</strong> ' . esc_html($custom_number) . '</p>';
        }

        if ($custom_select) {
            echo '<p><strong>Custom Select:</strong> ' . esc_html($custom_select) . '</p>';
        }

        echo '</div>';
    }
}

?>
