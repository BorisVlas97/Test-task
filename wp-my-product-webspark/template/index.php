<?php
global $_SESSION;
session_start();
wp_head();

switch (true) {
    case (is_page('my-account-add-product')):
        include_once 'template-part/add-product.php';
        break;
    case (is_page('my-account-my-products')):
        include_once 'template-part/my-products.php';
        break;
}

wp_footer();
