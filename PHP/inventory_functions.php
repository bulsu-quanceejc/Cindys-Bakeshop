<?php
// 1) Add inventory entry for a product
function addInventory($pdo, $productId, $stockQuantity) {
    $stmt = $pdo->prepare("
        INSERT INTO Inventory (Product_ID, Stock_Quantity)
        VALUES (:product_id, :stock_quantity)
    ");
    $stmt->execute([
        ':product_id' => $productId,
        ':stock_quantity' => $stockQuantity
    ]);
    return $pdo->lastInsertId();
}

// 2) Get inventory record by Product_ID
function getInventoryByProductId($pdo, $productId) {
    $stmt = $pdo->prepare("
        SELECT * FROM Inventory WHERE Product_ID = :product_id
    ");
    $stmt->execute([':product_id' => $productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 3) Get all inventory records
function getAllInventory($pdo) {
    $stmt = $pdo->query("SELECT * FROM Inventory");
    return $stmt->fetchAll();
}

// 4) Update stock quantity for a product
function updateInventoryStock($pdo, $productId, $stockQuantity) {
    $stmt = $pdo->prepare("
        UPDATE Inventory
        SET Stock_Quantity = :stock_quantity
        WHERE Product_ID = :product_id
    ");
    $stmt->execute([
        ':stock_quantity' => $stockQuantity,
        ':product_id' => $productId
    ]);
    return $stmt->rowCount();
}

// 5) Adjust stock quantity (+/-)
function adjustInventoryStock($pdo, $productId, $quantityChange) {
    $stmt = $pdo->prepare("
        UPDATE Inventory
        SET Stock_Quantity = Stock_Quantity + :quantity_change
        WHERE Product_ID = :product_id
    ");
    $stmt->execute([
        ':quantity_change' => $quantityChange,
        ':product_id' => $productId
    ]);
    return $stmt->rowCount();
}

// 6) Delete an inventory record by Product_ID
function deleteInventoryByProductId($pdo, $productId) {
    $stmt = $pdo->prepare("
        DELETE FROM Inventory WHERE Product_ID = :product_id
    ");
    $stmt->execute([':product_id' => $productId]);
    return $stmt->rowCount();
}
?>
