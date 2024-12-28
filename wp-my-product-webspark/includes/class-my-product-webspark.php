<?php
class My_Product_Webspark {
    public function run() {
        $this->my_product_webspark_filters();
    }

    public static function my_product_webspark_add_product () {
        if (is_user_logged_in()) {
            $product_data = $_POST;

            $attachment_id = (new My_Product_Webspark)->upload_img();

            $product = new WC_Product_Simple();

            $product->set_name($product_data['product_name']);
            $product->set_regular_price($product_data['product_price']);
            if ($attachment_id) {
                $product->set_image_id($attachment_id);
            }
            $product->set_description($product_data['product_description']);
            $product->set_status('pending');

            $product_id = $product->save();

            if (get_post_type($product_id) === 'product') {
                update_post_meta($product_id, 'product_count', $product_data['product_count']);
                return true;
            }
        }

        return false;
    }

    public static function get_edit_product($product_id) {
        $product = false;

        $post = get_post($product_id);
        $product_author_id = $post->post_author;

        if (is_user_logged_in() && $product_author_id == get_current_user_id()){
            $product = wc_get_product($product_id);
        }

        return $product;
    }

    public static function edit_product() {
        if (is_user_logged_in()) {
            $product_data = $_POST;
            $product_id = (int)$product_data['edit_product_id'];

            global $wpdb;
            $data = [
                'post_status' => 'pending',
                'post_title' => $product_data['product_name'],
                'post_content' => $product_data['product_description']
            ];

            $wpdb->update('wp_posts', $data, ['ID' => $product_id]);

            update_post_meta($product_id, '_regular_price', $product_data['product_price']);
            update_post_meta($product_id, '_price', $product_data['product_price']);
            update_post_meta($product_id, 'count', $product_data['product_count']);

            $attachment_id = (new My_Product_Webspark)->upload_img();
            if (!is_wp_error($attachment_id) && $attachment_id) {
                update_post_meta($product_id, '_thumbnail_id', $attachment_id);
            }

            return true;
        }
        return false;
    }

    private function my_product_webspark_filters() {
        add_filter('woocommerce_account_menu_items', function ($items) {
            $items['add-product'] = 'Add product';
            $items['my-products'] = 'My products';

            return $items;
        });

        add_filter('woocommerce_get_endpoint_url', function ($url, $endpoint) {
            if ($endpoint === 'add-product') {
                $url = home_url('my-account-add-product');
            }

            if ($endpoint === 'my-products') {
                $url = home_url('my-account-my-products');
            }

            return $url;
        }, 10, 2);

        add_filter('template_include', function ($page_template) {

            if ( is_page( 'my-account-add-product' ) || is_page( 'my-account-my-products' ) ) {
                $page_template = MY_PRODUCT_WEBSPARK_DIR . '/template/index.php';
            }

            return $page_template;
        });
    }

    private function upload_img() {
        $attachment_id = '';

        if (isset($_FILES) && !empty($_FILES)) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');

            $attachment_id = media_handle_upload('product_img', 0);
        }

        return $attachment_id;
    }
}