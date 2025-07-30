<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['confirm_password']) && isset($_POST['new_password']) && isset($_POST['password']) && isset($_POST['full_name']) && $_SESSION['role'] == 'employee') {
	include "../DB_connection.php";

	function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	
	$password = validate_input($_POST['password']);
	$full_name = validate_input($_POST['full_name']);
	$new_password = validate_input($_POST['new_password']);
	$confirm_password = validate_input($_POST['confirm_password']);
   $id = $_SESSION['id'];

	if (empty($password) || empty($new_password) || empty($confirm_password) ) {
		$em = "Password is required";
		header("Location: ../edit_profile.php?error=$em");
		exit();
	}else if (empty($full_name)) {
		$em = "Full name is required";
		header("Location: ../edit_profile.php?error=$em");
		exit();
	}else if ($confirm_password != $new_password) {
		$em = "New password and confirm password do not match";
		header("Location: ../edit_profile.php?error=$em");
		exit();
	}else {
	
	   include "Model/User.php";

	   $user = get_user_by_id($conn, $id);
	   if ($user) {
		if (password_verify($password, $user['password'])) {
			$new_password = password_hash($new_password, PASSWORD_DEFAULT);
			// Handle profile image upload
			$profile_image = $user['profile_image'] ?? null;
			if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
				$uploadDir = '../uploads/profile/';
				if (!is_dir($uploadDir)) {
					mkdir($uploadDir, 0777, true);
				}
				$filename = basename($_FILES['profile_image']['name']);
				$targetFile = $uploadDir . time() . '_' . $filename;
				if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
					$profile_image = 'uploads/profile/' . time() . '_' . $filename;
				}
			}
			// Update profile with image
			$data = array($full_name, $new_password, $profile_image, $id);
			update_profile_with_image($conn, $data);
			$em = "User updated successfully";
			header("Location: ../edit_profile.php?success=$em");
			exit();
		}else {
			$em = "Incorrect password";
			header("Location: ../edit_profile.php?error=$em");
			exit();
		}
	   }else {
			$em = "Unknown error occurred";
		   header("Location: ../edit_profile.php?error=$em");
		   exit();
		   }

	
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit_profile.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}