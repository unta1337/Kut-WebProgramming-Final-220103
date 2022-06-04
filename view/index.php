<!-- 메인 페이지 -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>To Do</title>

		<?php
			# 필요 파일 가져오기.

			include '../util/LogUtil.php';

			include '../model/repo/TaskRepo.php';
			include '../model/repo/UserRepo.php';
		?>
	</head>
	<body>
		<?php
			session_start();

			# 세션으로부터 필요한 정보 불러오기.
			$dbUrl = $_SESSION['dbUrl'];
			$dbUser = $_SESSION['dbUser'];
			$dbPasswd = $_SESSION['dbPasswd'];
			$dbName = $_SESSION['dbName'];

			$connection = mysqli_connect($dbUrl, $dbUser, $dbPasswd, $dbName);

			$userRepo = new UserRepo($connection);
			$taskRepo = new TaskRepo($connection);

			$user = $_SESSION['user'];

			# 할 일 추가.
			if (isset($_POST['addTask'])) {
				$taskRepo->addTask($_POST['content'], $user['id_uniq']);
			}

			# 할 일 삭제.
			if (isset($_GET['deleteTask'])) {
				$taskRepo->deleteTask($_GET['deleteTask']);
				header('Location: index.php');
			}

			# 완료로 표시.
			if (isset($_GET['flipDone'])) {
				$taskRepo->flipDone($_GET['flipDone']);
				header('Location: index.php');
			}

			# 로그아웃.
			if (isset($_POST['logOut'])) {
				# 세선을 종료하고 로그인 화면으로 돌아가기.
				unset($_SESSION);
				header('Location: signIn.php');
			}

			# 다른 사용자의 할 일 목록 조회.
			if (isset($_POST['viewOther'])) {
				$other = $userRepo->getUserById($_POST['otherUser']);

				if (!$other) {
					header('Location: index.php');
					return;
				}

				$_SESSION['other'] = $other;
				header('Location: viewOther.php');
			}

			# 로그아웃 및 다른 사용자의 할 일 목록 조회 버튼을 표시.
			echo '<h1>' . $user['id'].'</h1>';
			echo '
				<form name="menu" method="post" action="index.php">
					<input type="submit" value="로그아웃" name="logOut" /> <br />
					<input type="text" name="otherUser" />
					<input type="submit" value="조회" name="viewOther" />
				</form>
			';

			# 할 일 추가하기.
			echo "
				<form name='addTask' method='post' action='index.php'>
					<input type='text' name='content' />
					<input type='submit' name='addTask' value='확인' />
				</form>
			";

			# 사용자의 할 일 목록 표시.
			$result = $taskRepo->getTasksByAuthor($user['id']);
			echo "<br>";
			foreach ($result as $row) {
				echo "<a href='index.php?deleteTask=".$row['task_id']."'>[X]</a>";
				echo "<a href='index.php?flipDone=".$row['task_id']."'>[O]</a>";
				echo " ";


				if ($row['is_done']) {
					echo "[완료] ";
				}
				$taskStr = htmlspecialchars($row['task'], ENT_QUOTES);
				echo $taskStr."<br>";
			}
		?>
	</body>
</html>