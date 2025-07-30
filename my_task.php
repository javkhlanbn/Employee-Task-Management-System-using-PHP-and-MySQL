<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	$tasks = get_all_tasks_by_id($conn, $_SESSION['id']);

 ?>
<!DOCTYPE html>
<html>
<head>
<title>Миний даалгавар</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
<h4 class="title">Миний даалгавар</h4>
			<?php if (isset($_GET['success'])) {?>
			<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
		<?php } ?>
			<?php if ($tasks != 0) { ?>
			<table class="main-table">
				<tr>
<th>#</th>
<th>Гарчиг</th>
<th>Тайлбар</th>
<th>Төлөв</th>
<th>Дуусах огноо</th>
<th>Файл</th>
<th>Үйлдэл</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$task['title']?></td>
					<td><?=$task['description']?></td>
					<td><?=$task['status']?></td>
					<td><?=$task['due_date']?></td>
					<td>
						<?php if (!empty($task['attachment'])): ?>
							<a href="uploads/<?=$task['attachment']?>" target="_blank">Файл татах</a>
						<?php else: ?>
							-
						<?php endif; ?>
					</td>
					<td>
						<a href="edit-task-employee.php?id=<?=$task['id']?>" class="edit-btn">Засах</a>
					</td>
				</tr>
			   <?php	} ?>
			</table>
		<?php }else { ?>
<h3>Хоосон</h3>
		<?php  }?>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
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