<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>To Do</title>

		<?php
			include 'util/LogUtil.php';

			include 'model/repo/TaskRepo.php';
			include 'model/repo/UserRepo.php';

			include 'view/TaskView.php';
			include 'view/LoginView.php';
		?>
	</head>
	<body>
		<?php
			session_start();

			$dbUrl = $_SESSION['dbUrl'];
			$dbUser = $_SESSION['dbUser'];
			$dbPasswd = $_SESSION['dbPasswd'];
			$dbName = $_SESSION['dbName'];

			$connection = mysqli_connect($dbUrl, $dbUser, $dbPasswd, $dbName);

			$userRepo = new UserRepo($connection);
			$taskRepo = new TaskRepo($connection);

			$taskView = new TaskView();

			$user = $_SESSION['user'];

			// Add Task
			if (isset($_POST['content'])) {
				LogUtil::log($_POST['content']);
				$taskRepo->addTask($_POST['content'], $user['id_uniq']);
			}

			// Delete Task
			if (isset($_GET['delete_task'])) {
				$taskRepo->deleteTask($_GET['delete_task']);
			}

			// Logout
			if (isset($_POST['logout'])) {
				unset($_SESSION);
				header('Location: login.php');
			}

			echo '<h1>' . $user['id'].'</h1>';
			echo '
				<form name="logout" method="post" action="index.php">
					<input type="submit" value="Logout" name="logout" />
				</form>
			';

			$taskView->getUserTask('index.php');

			$result = $taskRepo->getTasksByAuthorIdUniq($user['id_uniq']);
			echo "<br>";
			foreach ($result as $row) {
				echo "<a href='index.php?delete_task=".$row['task_id']."'>[X]</a>";
				echo " ".$row['task']."<br>";
			}
		?>
	</body>
</html>