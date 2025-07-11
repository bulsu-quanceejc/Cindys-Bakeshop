<?php
// 1) Add a new product
function addProduct($pdo, $name, $description, $price, $stock_quantity, $category) {
    $stmt = $pdo->prepare("
        INSERT INTO Product (Name, Description, Price, Stock_Quantity, Category)
        VALUES (:name, :description, :price, :stock_quantity, :category)
    ");
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock_quantity' => $stock_quantity,
        ':category' => $category
    ]);
    return $pdo->lastInsertId();
}

// 2) Get all products
function getAllProducts($pdo) {
    $stmt = $pdo->query("SELECT * FROM Product");
    return $stmt->fetchAll();
}

// 3) Get a product by ID
function getProductById($pdo, $productId) {
    $stmt = $pdo->prepare("SELECT * FROM Product WHERE Product_ID = :product_id");
    $stmt->execute([':product_id' => $productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 4) Update product details
function updateProductById($pdo, $productId, $name, $description, $price, $stock_quantity, $category) {
    $stmt = $pdo->prepare("
        UPDATE Product
        SET Name = :name,
            Description = :description,
            Price = :price,
            Stock_Quantity = :stock_quantity,
            Category = :category
        WHERE Product_ID = :product_id
    ");
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock_quantity' => $stock_quantity,
        ':category' => $category,
        ':product_id' => $productId
    ]);
    return $stmt->rowCount(); // rows updated
}

// 5) Delete product by ID
function deleteProductById($pdo, $productId) {
    $stmt = $pdo->prepare("DELETE FROM Product WHERE Product_ID = :product_id");
    $stmt->execute([':product_id' => $productId]);
    return $stmt->rowCount();
}

// 6) Search products by name or category
function searchProducts($pdo, $keyword) {
    $stmt = $pdo->prepare("
        SELECT * FROM Product
        WHERE Name LIKE :kw OR Category LIKE :kw
    ");
    $stmt->execute([':kw' => "%$keyword%"]);
    return $stmt->fetchAll();
}

// 7) Adjust stock quantity (+/-)
function adjustProductStock($pdo, $productId, $quantityChange) {
    $stmt = $pdo->prepare("
        UPDATE Product
        SET Stock_Quantity = Stock_Quantity + :quantity_change
        WHERE Product_ID = :product_id
    ");
    $stmt->execute([
        ':quantity_change' => $quantityChange,
        ':product_id' => $productId
    ]);
    return $stmt->rowCount();
}

// 8) Count total products (optional)
function countProducts($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM Product");
    return $stmt->fetchColumn();
}
?>
