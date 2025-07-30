<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	$tasks = get_all_tasks_by_id($conn, $_SESSION['id']);

	// ✅ Даалгаврыг үлдсэн хоногоор нь эрэмбэлэх (хугацаагүй доор гарна)
	if ($tasks != 0 && is_array($tasks)) {
		usort($tasks, function($a, $b) {
			$today = new DateTime();
			$dateA = !empty($a['due_date']) ? new DateTime($a['due_date']) : null;
			$dateB = !empty($b['due_date']) ? new DateTime($b['due_date']) : null;

			// Хугацаагүйг доор гаргах
			if (!$dateA) return 1;
			if (!$dateB) return -1;

			return $dateA <=> $dateB;
		});
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
<style>
tr.warning td { background-color: #fff176; }
tr.urgent td { background-color: #ff5252; color: white; }
tr.overdue td { background-color: #d50000; color: white; }
tr.completed td { background-color: #90caf9; color: #222; }
.main-table td, .main-table th { padding: 16px 10px; }
</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
<h4 class="title">Миний даалгавар</h4>
			<?php if (isset($_GET['success'])) { ?>
			<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
		<?php } ?>

		<?php 
		if ($tasks != 0 && is_array($tasks)) { 
			$i = 0;
			$activeTasks = [];
			$completedTasks = [];
			foreach ($tasks as $task) {
				if ($task['status'] === 'completed') {
					$completedTasks[] = $task;
				} else {
					$activeTasks[] = $task;
				}
			}
		?>
		<style>
			.legend {
				margin-bottom: 10px;
				font-size: 14px;
			}
			.legend span {
				display: inline-block;
				width: 20px;
				height: 20px;
				margin-right: 5px;
				vertical-align: middle;
				border: 1px solid #ccc;
			}
			.legend-warning { background-color: #fff176; }
			.legend-urgent { background-color: #ff5252; }
			.legend-overdue { background-color: #d50000; }
		</style>
		<div class="legend">
			<span class="legend-warning"></span> 5 хоног дутуу  
			<span class="legend-urgent"></span> 2 хоног дутуу  
			<span class="legend-overdue"></span> хугацаа хэтэрсэн  
		</div>
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
			<?php foreach ($activeTasks as $task) { 
				$dueClass = "";
				if (!empty($task['due_date'])) {
					$today = new DateTime();
					$dueDate = new DateTime($task['due_date']);
					$interval = $today->diff($dueDate)->days;
					$isPast = $dueDate < $today;
					if ($isPast) {
						$dueClass = "overdue";
					} elseif ($interval <= 2) {
						$dueClass = "urgent";
					} elseif ($interval <= 5) {
						$dueClass = "warning";
					}
				}
			?>
			<tr class="<?=$dueClass?>">
				<td><?=++$i?></td>
				<td><?=$task['title']?></td>
				<td><?=$task['description']?></td>
				<td><?=$task['status']?></td>
				<td><?php if ($task['due_date'] == "") echo "Хугацаагүй"; else echo $task['due_date']; ?></td>
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
			<?php } ?>
		</table>
		<?php if (count($completedTasks) > 0) { ?>
		<h4 class="title-2">Дууссан даалгаврууд</h4>
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
			<?php $j = 0; foreach ($completedTasks as $task) { ?>
			<tr class="completed">
				<td><?=++$j?></td>
				<td><?=$task['title']?></td>
				<td><?=$task['description']?></td>
				<td><?=$task['status']?></td>
				<td><?php if ($task['due_date'] == "") echo "Хугацаагүй"; else echo $task['due_date']; ?></td>
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
			<?php } ?>
		</table>
		<?php } ?>
		<?php } else { ?>
			<h3>Хоосон</h3>
		<?php } ?>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>

</body>
</html>
<?php 
} else { 
   $em = "Анх удаа нэвтэрч байна";
   header("Location: login.php?error=$em");
   exit();
}
?>
