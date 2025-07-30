<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";
	
	$text = "Бүх даалгаврууд";
	if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Due Today") {
		$text = "Due Today";
	  $tasks = get_all_tasks_due_today($conn);
	  $num_task = count_tasks_due_today($conn);

	}else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Overdue") {
		$text = "Overdue";
	  $tasks = get_all_tasks_overdue($conn);
	  $num_task = count_tasks_overdue($conn);

	}else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "No Deadline") {
		$text = "No Deadline";
	  $tasks = get_all_tasks_NoDeadline($conn);
	  $num_task = count_tasks_NoDeadline($conn);

	}else{
		 $tasks = get_all_tasks($conn);
	   $num_task = count_tasks($conn);
	}
	$users = get_all_users($conn);
	

 ?>
<!DOCTYPE html>
<html>
<head>
<title>Бүх даалгавар</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title-2">
<a href="create_task.php" class="btn">Даалгавар үүсгэх</a>
<a href="tasks.php?due_date=Due Today">Өнөөдөр дуусах</a>
<a href="tasks.php?due_date=Overdue">Хоцорсон</a>
<a href="tasks.php?due_date=No Deadline">Хугацаагүй</a>
				<a href="tasks.php">Бүх даалгаврууд</a>
 
			</h4>
		 <h4 class="title-2"><?=$text?> (<?=$num_task?>)</h4>
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
<th>Хариуцагч</th>
<th>Дуусах огноо</th>
<th>Төлөв</th>
<th>Үйлдэл</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$task['title']?></td>
					<td><?=$task['description']?></td>
					<td>
						<?php 
				  foreach ($users as $user) {
						if($user['id'] == $task['assigned_to']){
							echo $user['full_name'];
						}}?>
				</td>
<td><?php if($task['due_date'] == "") echo "Хугацаагүй";
else echo $task['due_date'];
?></td>
				<td><?=$task['status']?></td>
					<td>
<a href="edit-task.php?id=<?=$task['id']?>" class="edit-btn">Засах</a>
<a href="delete-task.php?id=<?=$task['id']?>" class="delete-btn">Устгах</a>
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
	var active = document.querySelector("#navList li:nth-child(4)");
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