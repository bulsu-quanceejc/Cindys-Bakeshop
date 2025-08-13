<?php
// 1) Add a new product
function addProduct($pdo, $name, $description, $price, $stock_quantity, $category, $imageFile = null) {
    $imageName = null;
    if ($imageFile && $imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
        $imageName = processImageUpload($imageFile);
    }

    $stmt = $pdo->prepare("
        INSERT INTO Product (Name, Description, Price, Stock_Quantity, Category, Image_Path)
        VALUES (:name, :description, :price, :stock_quantity, :category, :image_path)
    ");
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock_quantity' => $stock_quantity,
        ':category' => $category,
        ':image_path' => $imageName
    ]);
    return $pdo->lastInsertId();
}

// 2) Get all products
function getAllProducts($pdo) {
    $stmt = $pdo->query("SELECT Product_ID, Name, Description, Price, Stock_Quantity, Category, Image_Path FROM Product");
    return $stmt->fetchAll();
}

// 3) Get a product by ID
function getProductById($pdo, $productId) {
    $stmt = $pdo->prepare("SELECT Product_ID, Name, Description, Price, Stock_Quantity, Category, Image_Path FROM Product WHERE Product_ID = :product_id");
    $stmt->execute([':product_id' => $productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 4) Update product details
function updateProductById($pdo, $productId, $name, $description, $price, $stock_quantity, $category, $imageFile = null) {
    $imageName = null;
    if ($imageFile && $imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
        $imageName = processImageUpload($imageFile);
    }

    $sql = "UPDATE Product SET Name = :name, Description = :description, Price = :price, Stock_Quantity = :stock_quantity, Category = :category";
    if ($imageName !== null) {
        $sql .= ", Image_Path = :image_path";
    }
    $sql .= " WHERE Product_ID = :product_id";

    $stmt = $pdo->prepare($sql);
    $params = [
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock_quantity' => $stock_quantity,
        ':category' => $category,
        ':product_id' => $productId
    ];
    if ($imageName !== null) {
        $params[':image_path'] = $imageName;
    }
    $stmt->execute($params);
    return $stmt->rowCount(); // rows updated
}

function processImageUpload($imageFile) {
    $allowedTypes = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif'];

    if ($imageFile['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $mime = mime_content_type($imageFile['tmp_name']);
    if (!isset($allowedTypes[$mime])) {
        return null;
    }

    if ($imageFile['size'] > 2 * 1024 * 1024) { // 2MB
        return null;
    }

    $targetDir = __DIR__ . '/../adminSide/products/uploads/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = uniqid('prod_', true) . $allowedTypes[$mime];
    $targetPath = $targetDir . $fileName;
    if (!move_uploaded_file($imageFile['tmp_name'], $targetPath)) {
        return null;
    }

    return $fileName;
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
