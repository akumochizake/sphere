<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$spheresInCart = array();
foreach ($_SESSION['cart'] as $sphereId) {
    $sphere = array(
        'id' => $sphereId,
        'name' => 'Сфера ' . $sphereId,
        'price' => 123 ,
    );

    $spheresInCart[] = $sphere;
}

header('Content-Type: application/json');
echo json_encode($spheresInCart);
?>
