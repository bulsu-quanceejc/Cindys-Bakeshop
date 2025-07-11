<?php
// 1) Create a new order
function addOrder($pdo, $userId, $orderDate, $status) {
    $stmt = $pdo->prepare("
        INSERT INTO `Order` (User_ID, Order_Date, Status)
        VALUES (:user_id, :order_date, :status)
    ");
    $stmt->execute([
        ':user_id' => $userId,
        ':order_date' => $orderDate,
        ':status' => $status
    ]);
    return $pdo->lastInsertId();
}

// 2) Get all orders
function getAllOrders($pdo) {
    $stmt = $pdo->query("SELECT * FROM `Order`");
    return $stmt->fetchAll();
}

// 3) Get all orders for a specific user
function getOrdersByUserId($pdo, $userId) {
    $stmt = $pdo->prepare("
        SELECT * FROM `Order` WHERE User_ID = :user_id
    ");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll();
}

// 4) Get a single order by ID
function getOrderById($pdo, $orderId) {
    $stmt = $pdo->prepare("
        SELECT * FROM `Order` WHERE Order_ID = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 5) Update order status
function updateOrderStatus($pdo, $orderId, $status) {
    $stmt = $pdo->prepare("
        UPDATE `Order`
        SET Status = :status
        WHERE Order_ID = :order_id
    ");
    $stmt->execute([
        ':status' => $status,
        ':order_id' => $orderId
    ]);
    return $stmt->rowCount();
}

// 6) Delete an order by ID
function deleteOrderById($pdo, $orderId) {
    $stmt = $pdo->prepare("
        DELETE FROM `Order` WHERE Order_ID = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    return $stmt->rowCount();
}

// 7) Count total orders
function countOrders($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM `Order`");
    return $stmt->fetchColumn();
}

// 8) Get orders by status
function getOrdersByStatus($pdo, $status) {
    $stmt = $pdo->prepare("
        SELECT * FROM `Order` WHERE Status = :status
    ");
    $stmt->execute([':status' => $status]);
    return $stmt->fetchAll();
}
?>
