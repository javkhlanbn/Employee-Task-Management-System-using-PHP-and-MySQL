<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";
	
	$text = "Бүх даалгаврууд";
	if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Due Today") {
		$text = "Өнөөдөр дуусах";
		$tasks = get_all_tasks_due_today($conn);
		$num_task = count_tasks_due_today($conn);

	}else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Overdue") {
		$text = "Хоцорсон";
		$tasks = get_all_tasks_overdue($conn);
		$num_task = count_tasks_overdue($conn);

	}else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "No Deadline") {
		$text = "Хугацаагүй";
		$tasks = get_all_tasks_NoDeadline($conn);
		$num_task = count_tasks_NoDeadline($conn);

	}else{
		$tasks = get_all_tasks($conn);
		$num_task = count_tasks($conn);
	}
	$users = get_all_users($conn);

	// ✅ Даалгаврыг үлдсэн хоногоор нь эрэмбэлэх (хугацаагүйг хамгийн доор гаргах)
	if ($tasks != 0 && is_array($tasks)) {
		usort($tasks, function($a, $b) {
			$today = new DateTime();
			$dateA = !empty($a['due_date']) ? new DateTime($a['due_date']) : null;
			$dateB = !empty($b['due_date']) ? new DateTime($b['due_date']) : null;

			// Хугацаагүйг хамгийн доор гаргах
			if (!$dateA) return 1;
			if (!$dateB) return -1;

			return $dateA <=> $dateB;
		});
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Бүх даалгавар</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		body {
			background: #f4f6fb;
			font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
			color: #222;
		}
		.main-table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 0 8px;
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			margin-bottom: 32px;
			overflow: hidden;
		}
		.main-table th {
			background: #22223b;
			color: #fff;
			font-weight: 600;
			padding: 18px 12px;
			border: none;
		}
		.main-table td {
			padding: 16px 12px;
			border: none;
			background: #fff;
			font-size: 15px;
		}
		tr.warning td { background-color: #fff9c4 !important; }
		tr.urgent td { background-color: #ffe0e0 !important; color: #b71c1c; }
		tr.overdue td { background-color: #ff5252 !important; color: #fff; }
		tr.completed td { background-color: #e3f2fd !important; color: #1976d2; }
		.edit-btn, .delete-btn, .btn {
			padding: 8px 18px;
			border-radius: 6px;
			border: none;
			font-size: 15px;
			font-weight: 500;
			cursor: pointer;
			transition: background 0.2s, color 0.2s;
			margin-right: 6px;
			text-decoration: none;
		}
		.edit-btn { background: #1976d2; color: #fff; }
		.edit-btn:hover { background: #1565c0; }
		.delete-btn { background: #d32f2f; color: #fff; }
		.delete-btn:hover { background: #b71c1c; }
		.btn { background: #43aa8b; color: #fff; margin-bottom: 10px; }
		.btn:hover { background: #2d6a4f; }
		.title-2 {
			font-size: 1.3rem;
			font-weight: 600;
			margin: 24px 0 12px 0;
			color: #22223b;
		}
		.success {
			background: #e6ffed;
			color: #256029;
			border-left: 5px solid #43aa8b;
			padding: 12px 18px;
			border-radius: 6px;
			margin-bottom: 18px;
		}
		.danger {
			background: #fff0f0;
			color: #b71c1c;
			border-left: 5px solid #d32f2f;
			padding: 12px 18px;
			border-radius: 6px;
			margin-bottom: 18px;
		}
		.filter-bar {
			display: flex;
			gap: 10px;
			align-items: center;
			flex-wrap: wrap;
		}
		.filter-link {
			text-decoration: none !important;
			color: #1976d2;
			background: #e3f2fd;
			padding: 7px 16px;
			border-radius: 5px;
			font-weight: 500;
			transition: background 0.2s, color 0.2s;
		}
		.filter-link:hover {
			background: #1976d2;
			color: #fff;
		}
		@media (max-width: 900px) {
			.main-table th, .main-table td { padding: 10px 4px; font-size: 13px; }
			.title-2 { font-size: 1.1rem; }
			.filter-bar { flex-direction: column; gap: 6px; }
		}
	</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
<h4 class="title-2 filter-bar">
	<a href="create_task.php" class="btn">Даалгавар үүсгэх</a>
	<a href="tasks.php?due_date=Due Today" class="filter-link">Өнөөдөр дуусах</a>
	<a href="tasks.php?due_date=Overdue" class="filter-link">Хоцорсон</a>
	<a href="tasks.php?due_date=No Deadline" class="filter-link">Хугацаагүй</a>
	<a href="tasks.php" class="filter-link">Бүх даалгаврууд</a>
</h4>
			

			<h4 class="title-2"><?=$text?> (<?=$num_task?>)</h4>

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
					<td>
						<?php 
						foreach ($users as $user) {
							if ($user['id'] == $task['assigned_to']) {
								echo $user['full_name'];
							}
						}
						?>
					</td>
					<td><?php if($task['due_date']=="") echo "Хугацаагүй"; else echo $task['due_date']; ?></td>
					<td><?=$task['status']?></td>
					<td>
						<a href="edit-task.php?id=<?=$task['id']?>" class="edit-btn">Засах</a>
						<a href="delete-task.php?id=<?=$task['id']?>" class="delete-btn">Устгах</a>
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
					<th>Хариуцагч</th>
					<th>Дуусах огноо</th>
					<th>Төлөв</th>
					<th>Үйлдэл</th>
				</tr>
				<?php $j = 0; foreach ($completedTasks as $task) { ?>
				<tr class="completed">
					<td><?=++$j?></td>
					<td><?=$task['title']?></td>
					<td><?=$task['description']?></td>
					<td>
						<?php 
						foreach ($users as $user) {
							if ($user['id'] == $task['assigned_to']) {
								echo $user['full_name'];
							}
						}
						?>
					</td>
					<td><?php if($task['due_date']=="") echo "Хугацаагүй"; else echo $task['due_date']; ?></td>
					<td><?=$task['status']?></td>
					<td>
						<a href="edit-task.php?id=<?=$task['id']?>" class="edit-btn">Засах</a>
						<a href="delete-task.php?id=<?=$task['id']?>" class="delete-btn">Устгах</a>
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
	var active = document.querySelector("#navList li:nth-child(4)");
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
