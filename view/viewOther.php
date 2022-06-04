<!-- 다른 사용자의 할 일 목록 조회 -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>Other's To Do</title>

		<?php
			# 필요 파일 가져오기.

			include '../util/LogUtil.php';
			include '../util/TextUtil.php';

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
            $other = $_SESSION['other'];

            # 이전 화면으로 돌아가기.
            if (isset($_POST['return'])) {
                header('Location: index.php');
                return;
            }

			# 조회할 사용자 이름 및 돌아가기 버튼 표시.
			echo '<h1>'.TextUtil::asPlainText($other['id']).'</h1>';
            echo '
                <form action="index.php" method="post">
                <input type="submit" value="Return" name="return">
                </form>
            ';

			# 조회할 사용자의 할 일 목록 조회.
			$result = $taskRepo->getTasksByAuthor($other['id']);
			echo "<br>";
			foreach ($result as $row) {
				if ($row['is_done']) {
					echo "[완료] ";
				}
				echo TextUtil::asPlainText($row['task'])."<br>";
			}
		?>
	</body>
</html>