<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
	include "DB_connection.php";
	include "app/Model/User.php";
	$user = get_user_by_id($conn, $_SESSION['id']);
	
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Профайл засах</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
<h4 class="title">Профайл засах <a href="profile.php">Профайл</a></h4>
		 <form class="form-1"
				  method="POST"
				  action="app/update-profile.php">
				  <?php if (isset($_GET['error'])) {?>
			<div class="danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
		  <?php } ?>

		  <?php if (isset($_GET['success'])) {?>
			<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
		  <?php } ?>
				<div class="input-holder">
<lable>Бүтэн нэр</lable>
<input type="text" name="full_name" class="input-1" placeholder="Бүтэн нэр" value="<?=$user['full_name']?>"><br>
				</div>

				<div class="input-holder">
<lable>Хуучин нууц үг</lable>
<input type="text" value="**********" name="password" class="input-1" placeholder="Хуучин нууц үг"><br>
				</div>
				<div class="input-holder">
<lable>Шинэ нууц үг</lable>
<input type="text" name="new_password" class="input-1" placeholder="Шинэ нууц үг"><br>
				</div>
				<div class="input-holder">
<lable>Нууц үг баталгаажуулах</lable>
<input type="text" name="confirm_password" class="input-1" placeholder="Нууц үг баталгаажуулах"><br>
				</div>

<button class="edit-btn">Өөрчлөх</button>
			</form>

		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
	active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "Анх удаа нэвтэрч байна";
   header("Location: login.php?error=$em");
   exit();
}
 ?>