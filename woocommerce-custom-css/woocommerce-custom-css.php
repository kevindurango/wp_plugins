<?php
/**
 * Plugin Name: WooCommerce Custom CSS Overrides
 * Description: A plugin to override WooCommerce template CSS styles with custom ones.
 * Version: 1.0
 * Author: Kevin
 * Author URI: Your Website URL
 * License: GPL2
 */

// Ensure no direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Hook into WordPress to add custom CSS
function woocommerce_custom_css() {
    if ( is_woocommerce() || is_cart() || is_checkout() ) {
        ?>
        <style type="text/css">
            /* Custom WooCommerce Star Rating Styles */
            .woocommerce-page .star-rating {
                color: #FFD700; /* Custom yellow color for the stars */
            }
            .woocommerce-page .star-rating span:before {
                color: #FFD700; /* Yellow for filled stars */
            }
            .woocommerce-page .star-rating span {
                font-size: 22px; /* Adjust the size of the stars */
            }
            .woocommerce-page .star-rating span:hover {
                transform: scale(1.2); /* Hover effect: makes stars bigger */
            }
            .woocommerce-page .star-rating span.empty {
                color: #ddd; /* Light gray for empty stars */
            }
        </style>
        <?php
    }
}

add_action( 'wp_head', 'woocommerce_custom_css' );
