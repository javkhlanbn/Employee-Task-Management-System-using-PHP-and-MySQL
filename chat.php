<?php 
// Simple chat UI for admin/employee
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}
include "DB_connection.php";
include "app/Model/User.php";
$users = get_all_users($conn);
$current_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .chat-container { max-width: 600px; margin: 30px auto; border: 1px solid #ccc; border-radius: 8px; background: #fafafa; }
        .chat-header { padding: 10px; background: #1976d2; color: #fff; border-radius: 8px 8px 0 0; }
        .chat-messages { height: 300px; overflow-y: auto; padding: 10px; background: #fff; }
        .chat-input { display: flex; border-top: 1px solid #eee; }
        .chat-input textarea { flex: 1; padding: 8px; border: none; resize: none; }
        .chat-input button { padding: 8px 16px; background: #1976d2; color: #fff; border: none; cursor: pointer; }
        .chat-message { margin-bottom: 10px; }
        .chat-message.me { text-align: right; }
        .chat-message .bubble { display: inline-block; padding: 8px 12px; border-radius: 16px; background: #e3f2fd; }
        .chat-message.me .bubble { background: #1976d2; color: #fff; }
    </style>
</head>
<body>
<div class="chat-container">
    <div class="chat-header">
        <form id="userSelectForm">
            <label for="receiver_id">Хэрэглэгч сонгох:</label>
            <select id="receiver_id" name="receiver_id">
                <?php
                if ($_SESSION['role'] == 'employee') {
                    foreach ($users as $user) {
                        if ($user['role'] == 'admin') {
                            echo '<option value="'.$user['id'].'">'.$user['full_name'].' (Админ)</option>';
                        }
                    }
                } else {
                    foreach ($users as $user) {
                        if ($user['role'] == 'employee' && $user['id'] != $current_id) {
                            echo '<option value="'.$user['id'].'">'.$user['full_name'].' (Ажилтан)</option>';
                        }
                    }
                }
                ?>
            </select>
        </form>
    </div>
    <div class="chat-messages" id="chatMessages"></div>
    <form class="chat-input" id="chatForm" autocomplete="off">
        <textarea id="message" name="message" rows="2" placeholder="Зурвас бичих..."></textarea>
        <button type="submit">Илгээх</button>
    </form>
</div>
<script>
const currentId = <?=$_SESSION['id']?>;
let receiverId = document.getElementById('receiver_id').value;
function fetchMessages() {
    fetch('app/get_messages.php?receiver_id=' + receiverId)
        .then(res => res.json())
        .then(data => {
            const chat = document.getElementById('chatMessages');
            chat.innerHTML = '';
            data.forEach(msg => {
                const isMe = msg.sender_id == currentId;
                chat.innerHTML += `<div class="chat-message${isMe ? ' me' : ''}"><span class="bubble">${msg.message}</span></div>`;
            });
            chat.scrollTop = chat.scrollHeight;
        });
}
document.getElementById('chatForm').onsubmit = function(e) {
    e.preventDefault();
    const message = document.getElementById('message').value.trim();
    if (!message) return;
    fetch('app/send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'receiver_id=' + receiverId + '&message=' + encodeURIComponent(message)
    }).then(res => res.json()).then(data => {
        if (data.success) {
            document.getElementById('message').value = '';
            fetchMessages();
        }
    });
};
document.getElementById('receiver_id').onchange = function() {
    receiverId = this.value;
    fetchMessages();
};
setInterval(fetchMessages, 2000);
fetchMessages();
</script>
</body>
</html>
