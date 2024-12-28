<?php

class My_Product_Webspark_Activator {

    public static function activate() {
        (new My_Product_Webspark_Activator)->create_pages();
    }

    private function create_pages () {
        $page_got_by_title = $this->get_page_by_title('Add product');

        if (!$page_got_by_title) {
            $data = [
                'post_title' => 'Add product',
                'post_content' => '',
                'post_type' => 'page',
                'post_name' => 'my-account-add-product',
                'post_status' => 'publish'
            ];
            $post_id = wp_insert_post($data);
        }

        $page_got_by_title = $this->get_page_by_title('My products');

        if (!$page_got_by_title) {
            $data = [
                'post_title' => 'My products',
                'post_content' => '',
                'post_type' => 'page',
                'post_name' => 'my-account-my-products',
                'post_status' => 'publish'
            ];
            $post_id = wp_insert_post($data);
        }
    }

    private function get_page_by_title ($title) {
        $posts = get_posts(
            [
                'post_type'              => 'page',
                'title'                  => $title,
                'post_status'            => 'all',
                'posts_per_page'         => 1,
            ]
        );

        if ( $posts ) {
            $page_got_by_title = $posts[0];
        }
        else {
            $page_got_by_title = null;
        }

        return (bool)$page_got_by_title;
    }
}