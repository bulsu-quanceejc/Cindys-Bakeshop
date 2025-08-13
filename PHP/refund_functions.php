<?php
// Functions for refund operations

function addRefund($pdo, $orderId, $userId, $reason, $date, $status = 'Pending') {
    $stmt = $pdo->prepare(
        "INSERT INTO refund (Order_ID, User_ID, Reason, Refund_Date, Status)
         VALUES (:order_id, :user_id, :reason, :date, :status)"
    );
    $stmt->execute([
        ':order_id' => $orderId,
        ':user_id' => $userId,
        ':reason' => $reason,
        ':date' => $date,
        ':status' => $status
    ]);
    return $pdo->lastInsertId();
}

function getAllRefunds($pdo) {
    $stmt = $pdo->query(
        "SELECT r.*, u.Name AS Customer
         FROM refund r
         LEFT JOIN User u ON r.User_ID = u.User_ID"
    );
    return $stmt->fetchAll();
}

function updateRefundStatus($pdo, $refundId, $status) {
    $stmt = $pdo->prepare(
        "UPDATE refund
         SET Status = :status
         WHERE Refund_ID = :id"
    );
    $stmt->execute([
        ':status' => $status,
        ':id' => $refundId
    ]);
    return $stmt->rowCount();
}
?>
