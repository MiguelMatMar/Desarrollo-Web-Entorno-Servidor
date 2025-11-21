<?php
  $total = 0;
  $pageTitle = 'Shopping Cart';
  require_once __DIR__ . '/_headers.php';
?>

<?php if (empty($cartItems)): ?>
  <div class="alert alert-info">Your shopping cart is empty. <a href="/">Continue shopping</a></div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th style="width:120px">Image</th>
          <th>Item</th>
          <th class="text-right" style="width:120px">Price</th>
          <th class="text-center" style="width:160px">Quantity</th>
          <th class="text-right" style="width:120px">Subtotal</th>
          <th style="width:120px">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($cartItems as $id => $quantity):
        if (!isset($products[$id])) continue;
        $product = $products[$id];
        $price = $product['price'];
        $subtotal = $quantity * $price;
        $total += $subtotal;
        $priceF = number_format($price, 2);
        $subtotalF = number_format($subtotal, 2);
      ?>
        <tr>
          <td class="text-center">
            <img src="/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-thumbnail" style="max-width:100px;">
          </td>
          <td>
            <strong><?= htmlspecialchars($product['name']) ?></strong>
            <div class="text-muted small"><?= htmlspecialchars($product['description']) ?></div>
          </td>
          <td class="text-right">€ <?= $priceF ?></td>
          <td class="text-center">
            <form action="/?action=changeCartQuantity&id=<?= urlencode($id) ?>" method="post" class="form-inline" style="display:inline-block;">
              <button type="submit" name="changeDirection" value="reduce" class="btn btn-default btn-xs" title="Reduce">
                <span class="glyphicon glyphicon-minus"></span>
              </button>
              <span class="mx-2" style="display:inline-block; width:30px; text-align:center"><?= (int)$quantity ?></span>
              <button type="submit" name="changeDirection" value="increase" class="btn btn-default btn-xs" title="Increase">
                <span class="glyphicon glyphicon-plus"></span>
              </button>
            </form>
          </td>
          <td class="text-right">€ <?= $subtotalF ?></td>
          <td>
            <a href="/?action=removeFromCart&id=<?= urlencode($id) ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Remove</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-md-6">
      <a href="/" class="btn btn-default">Continue shopping</a>
    </div>
    <div class="col-md-6 text-right">
      <?php $total = number_format($total, 2); ?>
      <h4>Total: € <?= $total ?></h4>
      <form action="/?action=checkout" method="post" style="display:inline-block;">
        <button type="submit" class="btn btn-success">Checkout</button>
      </form>
    </div>
  </div>
<?php endif; ?>

</div>
</body>
</html>