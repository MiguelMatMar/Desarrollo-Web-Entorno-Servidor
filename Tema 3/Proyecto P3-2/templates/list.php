<?php
    require_once('../public/index.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping site: Product List</title>
    <link rel="stylesheet" href="/css/products.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Glyphicons (Bootstrap 3) -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
</head>
<body class="container">

    <h1>List of Products</h1>

    <div class="row">
        <?php

            foreach ($products as $id => $product):
                $price = number_format($product['price'], 2);
        ?>
            <div class="product col-md-2 text-center">
                <img src="../public/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">

                <?= starsHtml($product['stars']) ?>

                <h1 class="fs-5"><?= $product['name'] ?></h1>

                <div class="price">
                    € <?= $price ?>
                    <form method="post" action="/?action=addToCart&id=<?= $id ?>" style="display: inline;">
                        <button class="btn btn-primary btn-sm">Add To Cart</button>
                    </form>
                </div>

                <div>
                    <?= $product['description'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
