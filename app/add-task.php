<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin' && isset($_POST['due_date'])) {
	include "../DB_connection.php";

	function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$title = validate_input($_POST['title']);
	$description = validate_input($_POST['description']);
	$assigned_to = validate_input($_POST['assigned_to']);
	$due_date = validate_input($_POST['due_date']);

	if (empty($title)) {
		$em = "Title is required";
		header("Location: ../create_task.php?error=$em");
		exit();
	}else if (empty($description)) {
		$em = "Description is required";
		header("Location: ../create_task.php?error=$em");
		exit();
	}else if ($assigned_to == 0) {
		$em = "Select User";
		header("Location: ../create_task.php?error=$em");
		exit();
	}else {
	
	   include "Model/Task.php";
	   include "Model/Notification.php";

	   // Handle file upload
	   $attachment = null;
	   if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
		   $uploadDir = '../uploads/';
		   if (!is_dir($uploadDir)) {
			   mkdir($uploadDir, 0777, true);
		   }
		   $filename = basename($_FILES['attachment']['name']);
		   $targetFile = $uploadDir . time() . '_' . $filename;
		   if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
			   $attachment = time() . '_' . $filename;
		   }
	   }
	   $data = array($title, $description, $assigned_to, $due_date, $attachment);
	   insert_task($conn, $data);

	   $notif_data = array("'$title' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү", $assigned_to, 'Шинэ даалгавар өгсөн');
	   insert_notification($conn, $notif_data);


	   $em = "Даалгаврыг амжилттай үүсгэсэн";
		header("Location: ../create_task.php?success=$em");
		exit();

	
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../create_task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../create_task.php?error=$em");
   exit();
}