<?php
require_once('./index.php');

try {

    // Crear productos
    $producto1 = new ProductoFisico(1, "Teclado Mecánico", 59.99);
    $producto2 = new ProductoDigital(2, "Curso Online", 29.90);
    $producto3 = new ProductoFisico(3, "Monitor 24 pulgadas", 120.00);

    // Crear categoría
    $categoria = new Categoria(100, "Tecnología");
    $categoria->addProducto($producto1);
    $categoria->addProducto($producto2);
    $categoria->addProducto($producto3);

    echo "<hr>";
    $categoria->listarProductos();
    echo "<br>Total categoría con impuestos: " . $categoria->getTotalConImpuestos() . " €<br>";

    echo "<hr>";

    // Crear carrito
    $carrito = new Carrito();
    $carrito->addProducto($producto2);
    $carrito->addProducto($producto3);

    echo "<br>Total del carrito: " . $carrito->totalCarrito() . " €";

    } catch (CarritoVacioException $e) {

        echo "<br><b>Carrito vacío:</b> " . $e->getMessage();

    } catch (CategoriaVaciaException $e) {

        echo "<br><b>Categoría vacía:</b> " . $e->getMessage();

    } catch (ProductoNoEncontradoException $e) {

        echo "<br><b>Error de producto:</b> " . $e->getMessage();

    } catch (Exception $e) {

        echo "<br><b>Error general:</b> " . $e->getMessage();

    }
?>
