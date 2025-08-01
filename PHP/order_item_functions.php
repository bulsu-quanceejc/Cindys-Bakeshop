<?php
// 1) Add an order item
function addOrderItem($pdo, $orderId, $productId, $quantity, $subtotal) {
    $stmt = $pdo->prepare("
        INSERT INTO Order_Item (Order_ID, Product_ID, Quantity, Subtotal)
        VALUES (:order_id, :product_id, :quantity, :subtotal)
    ");
    $stmt->execute([
        ':order_id' => $orderId,
        ':product_id' => $productId,
        ':quantity' => $quantity,
        ':subtotal' => $subtotal
    ]);
    return $pdo->lastInsertId();
}

// 2) Get all order items for an order
function getOrderItemsByOrderId($pdo, $orderId) {
    $stmt = $pdo->prepare("
        SELECT * FROM Order_Item WHERE Order_ID = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    return $stmt->fetchAll();
}

// 3) Get all order items for a product
function getOrderItemsByProductId($pdo, $productId) {
    $stmt = $pdo->prepare("
        SELECT * FROM Order_Item WHERE Product_ID = :product_id
    ");
    $stmt->execute([':product_id' => $productId]);
    return $stmt->fetchAll();
}

// 4) Get a single order item by ID
function getOrderItemById($pdo, $orderItemId) {
    $stmt = $pdo->prepare("
        SELECT * FROM Order_Item WHERE Order_Item_ID = :order_item_id
    ");
    $stmt->execute([':order_item_id' => $orderItemId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 5) Update quantity and subtotal of an order item
function updateOrderItem($pdo, $orderItemId, $quantity, $subtotal) {
    $stmt = $pdo->prepare("
        UPDATE Order_Item
        SET Quantity = :quantity,
            Subtotal = :subtotal
        WHERE Order_Item_ID = :order_item_id
    ");
    $stmt->execute([
        ':quantity' => $quantity,
        ':subtotal' => $subtotal,
        ':order_item_id' => $orderItemId
    ]);
    return $stmt->rowCount();
}

// 6) Delete an order item by ID
function deleteOrderItemById($pdo, $orderItemId) {
    $stmt = $pdo->prepare("
        DELETE FROM Order_Item WHERE Order_Item_ID = :order_item_id
    ");
    $stmt->execute([':order_item_id' => $orderItemId]);
    return $stmt->rowCount();
}

// 7) Delete all order items for an order
function deleteOrderItemsByOrderId($pdo, $orderId) {
    $stmt = $pdo->prepare("
        DELETE FROM Order_Item WHERE Order_ID = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    return $stmt->rowCount();
}

// 8) Calculate total for an order by summing its items
function calculateOrderTotal($pdo, $orderId) {
    $stmt = $pdo->prepare("
        SELECT SUM(Subtotal) FROM Order_Item WHERE Order_ID = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    return $stmt->fetchColumn();
}
?>