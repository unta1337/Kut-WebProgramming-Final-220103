<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>Login Page</title>

		<?php
			include 'init.php';

			include 'util/LogUtil.php';

			include 'model/repo/TaskRepo.php';
			include 'model/repo/UserRepo.php';

			include 'view/TaskView.php';
			include 'view/LoginView.php';
		?>
	</head>
	<body>
        <?php
			$connection = mysqli_connect($_SESSION['dbUrl'], $_SESSION['dbUser'], $_SESSION['dbPasswd'], $_SESSION['dbName']);

			$userRepo = new UserRepo($connection);

			$loginView = new LoginView();

			$loginView->login('login.php');

			// Login
			if (isset($_POST['login'])) {
				$user = $userRepo->getUserById($_POST['id']);

				if (!$user || $_POST['passwd'] != $user['passwd']) {
					header('Location: login.php');
					return;
				}

				$_SESSION['user'] = $user;
				header('Location: index.php');
			}

			// Sign up
			if (isset($_POST['signUp'])) {
				$user = $userRepo->getUserById($_POST['id']);

				if ($user || !$_POST['id'] || !$_POST['passwd']) {
					header('Location: login.php');
					return;
				}

				$userRepo->addUser($_POST['id'], $_POST['passwd']);

				LogUtil::alert('Sign up.');
			}
        ?>
	</body>
</html>