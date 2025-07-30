<?php
session_start();
include "../DB_connection.php";
if (isset($_SESSION['id']) && isset($_GET['receiver_id'])) {
    $user_id = $_SESSION['id'];
    $receiver_id = intval($_GET['receiver_id']);
    $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY created_at ASC");
    $stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id]);
    $messages = $stmt->fetchAll();
    echo json_encode($messages);
} else {
    echo json_encode([]);
}
?>
