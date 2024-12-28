<?php
$products = wc_get_products([
    'author' => get_current_user_id()
]);

if (isset($_POST['delete'])) {

    wp_delete_post((int)$_POST['product_id']);

}

?>

<main>
    <div class="product-data">
        <?php
        if (is_array($products)) {
            foreach ($products as $product){
                $product_id = $product->id;
                ?>
                <div class="product-item">
                    <div class="product-item-data name">Name: <?= $product->name ?></div>
                    <div class="product-item-data count">Count: <?= get_post_meta($product_id, 'product_count', true) ?></div>
                    <div class="product-item-data price">Price: <?= $product->get_price() ?></div>
                    <div class="product-item-data status">Status: <?= $product->status ?></div>
                    <div class="product-item-data edit"><a href="<?= home_url('my-account-add-product') . '?product_id=' . $product_id ?>">Edit</a></div>
                    <div class="product-item-data delete">
                        <form action="<?php echo  get_permalink(get_the_ID()); ?>" method="POST">
                            <input type="submit" name="delete" value="Delete">
                            <input type="hidden" name="product_id" value="<?= $product_id ?>">
                        </form>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</main>

<style>
    .product-item {
        display: flex
    }
    .product-item-data {
        margin: 10px;
    }
</style>