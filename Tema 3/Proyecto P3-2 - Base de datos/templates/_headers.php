<!doctype html>
<?php if (session_status() === PHP_SESSION_NONE) { @session_start(); } ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping site: <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Store' ?></title>
  <link rel="stylesheet" href="/css/products.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">My Shop</a>
      </div>
      <div class="collapse navbar-collapse" id="main-navbar">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['user']['id'])): ?>
            <li><a href="/pedidos.php"> Mis Pedidos </a></li>
            <li><a href="/logout.php">Cerrar Sesión (<?= htmlspecialchars($_SESSION['user']['nombre'] ?? '') ?>)</a></li>
          <?php else: ?>
            <li><a href="/login.php">Iniciar Sesión</a></li>
          <?php endif; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php
            $cartCount = 0;
            if (session_status() === PHP_SESSION_NONE) {
                @session_start();
            }
            if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                $cartCount = array_sum($_SESSION['cart']);
            }
          ?>
          <li><a href="/?action=cart"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge"><?= $cartCount ?></span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h1 class="page-header"><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Store' ?></h1>