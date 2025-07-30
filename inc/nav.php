<nav class="side-bar">
			<div class="user-p">
				<img src="img/user.png">
<h4><?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : '@'.$_SESSION['username']; ?></h4>
			</div>
			
			<?php 

			   if($_SESSION['role'] == "employee"){
			 ?>
			 <!-- Employee Navigation Bar -->
			<ul id="navList">
				<li>
					<a href="index.php">
						<i class="fa fa-tachometer" aria-hidden="true"></i>
						<span>Хянах самбар</span>
					</a>
				</li>
				<li>
					<a href="my_task.php">
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>Миний даалгавар</span>
					</a>
				</li>
				<li>
					<a href="profile.php">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span>Профайл</span>
					</a>
				</li>
				<li>
					<a href="notifications.php">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<span>Мэдэгдэл</span>
					</a>
				</li>
			   <li>
				   <a href="chat.php" class="<?php if(basename($_SERVER['PHP_SELF'])=='chat.php') echo 'active'; ?>">
					   <i class="fa fa-comments" aria-hidden="true"></i>
					   <span>Чат</span>
				   </a>
			   </li>
			   <li>
				   <a href="logout.php">
					   <i class="fa fa-sign-out" aria-hidden="true"></i>
					   <span>Гарах</span>
				   </a>
			   </li>
			</ul>
		<?php }else { ?>
			<!-- Admin Navigation Bar -->
			<ul id="navList">
				<li>
					<a href="index.php">
						<i class="fa fa-tachometer" aria-hidden="true"></i>
						<span>Хянах самбар</span>
					</a>
				</li>
				<li>
					<a href="user.php">
						<i class="fa fa-users" aria-hidden="true"></i>
						<span>Ажилтан удирдах</span>
					</a>
				</li>
				<li>
					<a href="create_task.php">
						<i class="fa fa-plus" aria-hidden="true"></i>
						<span>Даалгавар үүсгэх</span>
					</a>
				</li>
				<li>
					<a href="tasks.php">
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>Бүх даалгаврууд</span>
					</a>
				</li>
			   <li>
				   <a href="chat.php">
					   <i class="fa fa-comments" aria-hidden="true"></i>
					   <span>Чат</span>
				   </a>
			   </li>
			   <li>
				   <a href="logout.php">
					   <i class="fa fa-sign-out" aria-hidden="true"></i>
					   <span>Гарах</span>
				   </a>
			   </li>
			</ul>
		<?php } ?>
		</nav>