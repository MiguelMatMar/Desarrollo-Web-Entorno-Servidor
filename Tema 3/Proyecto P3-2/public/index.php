<?php
    require_once('../src/functions.php');
    $products = [];
    $products['010'] = [
            'name' => 'Sandwich',
            'description' =>
            'A filling, savory snack of peanut butter and jelly.',
            'price' => 1.00,
            'stars' => 4,
            'image' => 'peanut_butter.png'
        ];
        $products['025'] = [
            'name' => 'Slice of cheesecake',
            'description' =>
            'Treat yourself to a chocolate-covered cheesecake slice.',
            'price' => 2.00,
            'stars' => 5,
            'image' => 'chocolate_cheese_cake.png'
        ];
        $products['005'] = [
            'name' => 'Pineapple',
            'description' => 'Un trozo de fruta exotica',
            'price' => 3.00,
            'stars' => 2,
            'image' => 'pineapple.png'
        ];
        $products['021'] = [
            'name' => 'Jelly donut',
            'description' => 'El mejor tipo de dona, rellena de mermelada dulce.',
            'price' => 2.50,
            'stars' => 3,
            'image' => 'jellydonut.png'
        ];
        $products['002'] = [
            'name' => 'Banana',
            'description' => 'La base para un buen batido y alta en potasio.',
            'price' => 0.50,
            'stars' => 5,
            'image' => 'banana.png'
        ];
    // Por defecto es la página de lista de productos
    $page = 'list.php';
        // Intentar encontrar "action=cart" en las variables de cadena de consulta
    $action = filter_input(INPUT_GET, 'action');
    if ('cart' == $action){
        // Si se encuentra, cambiar el archivo de plantilla a mostrar
        $page = 'cart.php';
    }
    // Leer y ejecutar la plantilla $page
    // 1
    require_once "./$page";
?>