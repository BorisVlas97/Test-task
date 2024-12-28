<?php
    $edit_product = isset($_SESSION['edit_product']) ? $_SESSION['edit_product'] : false;
    $title = get_the_title();
    $product_name = '';
    $product_price = '';
    $product_count = '';
    $product_description = '';
    $product_submit = 'Add product';

    if (isset($_GET['product_id'])) {
        $product = My_Product_Webspark::get_edit_product($_GET['product_id']);
        $title = __('Edit product ', '') . $product->name;
        $product_name = $product->name;
        $product_price = $product->get_price();
        $product_count = get_post_meta($product->id, 'product_count', true);
        $product_description = $product->description;
        $product_submit = 'Edit product';
        $_SESSION['edit_product'] = true;
        $_SESSION['product'] = $product;
    }
    if (isset($_POST['product_submit'])) {
        if ($edit_product) {
//            $product = $_SESSION['product'];
            $status = My_Product_Webspark::edit_product();
            unset($_SESSION['product']);
        }
        else {
            $status = My_Product_Webspark::my_product_webspark_add_product();
        }
        $_SESSION['edit_product'] = false;
    }
?>
<main>
    <?php if (isset($status)) { ?>
        <?php if ($status) { ?>
            <div class="status created"><?= $_SESSION['edit_product'] ? __('Product edit') : __('Product created') ?></div>
        <?php } else { ?>
            <div class="status error">Has error</div>
        <?php } ?>
    <?php } ?>
    <h1><?= $title ?></h1>
    <div class="add-product-main">
        <div class="add-product-form">
            <form action="<?php echo  get_permalink(get_the_ID()); ?>" method="POST" enctype="multipart/form-data">
                <?php if (isset($_GET['product_id'])) { ?>
                    <input type="hidden" name="edit_product_id" value="<?= $_GET['product_id'] ?>">
                <?php } ?>
                <div class="item">
                    <label for="product_name">Name</label>
                    <input type="text" name="product_name" id="product_name" value="<?= $product_name ?>">
                </div>
                <div class="item">
                    <label for="product_price">Price</label>
                    <input type="number" step="0.01" name="product_price" id="product_price" value="<?= $product_price ?>">
                </div>
                <div class="item">
                    <label for="product_count">Count</label>
                    <input type="number" name="product_count" id="product_count" value="<?= $product_count ?>">
                </div>
                <div class="item">
                    <label for="product_description">Description</label>
                    <textarea name="product_description" id="product_description">
                        <?= $product_description ?>
                    </textarea>
                </div>
                <div class="item">
                    <label for="product_img">Img</label>
                    <input type="file" id="product_img" name="product_img" accept="image/png, image/jpeg" />
                </div>
                <input class="item" type="submit" value="<?= $product_submit ?>" name="product_submit" />
            </form>
        </div>
    </div>
</main>

<style>
    .add-product-main {
        margin: 0 20px 0 20px;
    }
    .add-product-main form .item {
        margin: 10px;
    }
</style>