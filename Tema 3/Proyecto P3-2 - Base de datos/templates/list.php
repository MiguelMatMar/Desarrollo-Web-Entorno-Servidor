<?php
  $pageTitle = 'List of products';
  require_once __DIR__ . '/_headers.php';
?>

<div class="row">
<?php foreach ($products as $id => $product):
  $price = number_format($product['price'], 2);
?>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style=" width:100%; object-fit:cover;">
      <div class="caption">
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p class="text-muted"><?= starsHtml($product['stars']) ?></p>
        <p class="small text-secondary"><?= htmlspecialchars($product['description']) ?></p>
        <p class="lead">€<?= $price ?></p>
        <p>
          <a href="/?action=addToCart&id=<?= urlencode($id) ?>" class="btn btn-primary" role="button">Add to cart</a>
          <a href="/?action=cart" class="btn btn-default">View cart</a>
        </p>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

</body>
</html>