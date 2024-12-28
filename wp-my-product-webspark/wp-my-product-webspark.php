<?php
/*
 * Plugin Name: My product webspark
 *
 * Requires at least: 6.5
 * Requires Plugins: woocommerce
 *
 * License: GPL2
 * License URI: https://www.gnu.org/license/gpl-2.0.html
 *
 * Version: 1.0
 */

define('MY_PRODUCT_WEBSPARK_DIR', WP_PLUGIN_DIR . '/wp-my-product-webspark');

function activate_my_product_webspark() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-my-product-webspark-activator.php';
    My_Product_Webspark_Activator::activate();
}

function deactivate_my_product_webspark() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-my-product-webspark-deactivator.php';
    My_Product_Webspark_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_my_product_webspark' );
register_deactivation_hook( __FILE__, 'deactivate_my_product_webspark' );


require plugin_dir_path( __FILE__ ) . 'includes/class-my-product-webspark.php';

function run_my_product_webspark() {
    $plugin = new My_Product_Webspark();
    $plugin->run();
}
run_my_product_webspark();