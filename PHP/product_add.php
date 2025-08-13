<?php
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/product_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['productName'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if ($name !== '' && $category !== '' && $price > 0 && $quantity >= 0) {
        $uploadDir = __DIR__ . '/../adminSide/products/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $filename = basename($_FILES['image']['name']);
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $filename);
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
        }

        addProduct($pdo, $name, $description, $price, $quantity, $category);
    }
}

header('Location: ../adminSide/products/ManageProduct.php');
exit;
?>

