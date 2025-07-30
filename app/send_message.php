<?php
session_start();
include "../DB_connection.php";
if (isset($_SESSION['id']) && isset($_POST['receiver_id']) && isset($_POST['message'])) {
    $sender_id = $_SESSION['id'];
    $receiver_id = intval($_POST['receiver_id']);
    $message = trim($_POST['message']);
    if ($message !== "") {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$sender_id, $receiver_id, $message]);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Message is empty."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
?>
