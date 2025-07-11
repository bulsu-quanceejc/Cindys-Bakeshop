<?php
// 1) Add delivery personnel
function addDeliveryPersonnel($pdo, $userId) {
    $stmt = $pdo->prepare("
        INSERT INTO Delivery_Personnel (User_ID)
        VALUES (:user_id)
    ");
    $stmt->execute([':user_id' => $userId]);
    return $pdo->lastInsertId();
}

// 2) Get all delivery personnel
function getAllDeliveryPersonnel($pdo) {
    $stmt = $pdo->query("SELECT * FROM Delivery_Personnel");
    return $stmt->fetchAll();
}

// 3) Get delivery personnel by ID
function getDeliveryPersonnelById($pdo, $personnelId) {
    $stmt = $pdo->prepare("
        SELECT * FROM Delivery_Personnel WHERE Delivery_Personnel_ID = :personnel_id
    ");
    $stmt->execute([':personnel_id' => $personnelId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 4) Get delivery personnel by User_ID
function getDeliveryPersonnelByUserId($pdo, $userId) {
    $stmt = $pdo->prepare("
        SELECT * FROM Delivery_Personnel WHERE User_ID = :user_id
    ");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 5) Delete delivery personnel by ID
function deleteDeliveryPersonnelById($pdo, $personnelId) {
    $stmt = $pdo->prepare("
        DELETE FROM Delivery_Personnel WHERE Delivery_Personnel_ID = :personnel_id
    ");
    $stmt->execute([':personnel_id' => $personnelId]);
    return $stmt->rowCount();
}

// 6) Delete delivery personnel by User_ID
function deleteDeliveryPersonnelByUserId($pdo, $userId) {
    $stmt = $pdo->prepare("
        DELETE FROM Delivery_Personnel WHERE User_ID = :user_id
    ");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->rowCount();
}
?>
