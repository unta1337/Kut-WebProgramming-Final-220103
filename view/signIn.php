<!-- 로그인 및 회원가입 -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"></meta>
		<title>Sign In</title>

		<?php
			# 초기화 작업 수행 및 필요 파일 가져오기.

			include '../model/init.php';

			include '../util/LogUtil.php';

			include '../model/repo/TaskRepo.php';
			include '../model/repo/UserRepo.php';
		?>
	</head>
	<body>
        <?php
			$connection = mysqli_connect($_SESSION['dbUrl'], $_SESSION['dbUser'], $_SESSION['dbPasswd'], $_SESSION['dbName']);

			$userRepo = new UserRepo($connection);

			# 로그인.
			if (isset($_POST['signIn'])) {
				# userRepo에서 사용자 정보를 가져오기.
				$user = $userRepo->getUserById($_POST['id']);

				# 사용자가 존재하지 않거나 비밀번호가 일치하지 않으면 아무 것도 하지 않음.
				if (!$user || $_POST['passwd'] != $user['passwd']) {
					header('Location: signIn.php');
					return;
				}

				# 사용자가 존재하고 비밀번호가 일치하면 세션에 사용자 정보를 저장하고 메인 페이지로 이동.
				$_SESSION['user'] = $user;
				header('Location: index.php');
			}

			# 가입.
			if (isset($_POST['signUp'])) {
				# 사용자 중복 검사.
				$user = $userRepo->getUserById($_POST['id']);

				# 사용자가 중복되거나 아이디 또는 비밀번호를 입력하지 않았으면 아무 것도 하지 않음.
				if ($user || !$_POST['id'] || !$_POST['passwd']) {
					header('Location: signIn.php');
					return;
				}

				# 사용자 추가 및 확인 메시지 출력.
				$userRepo->addUser($_POST['id'], $_POST['passwd']);
				LogUtil::alert('가입되었습니다.');
			}

			# 사용자 정보 입력 폼.
			echo "
				<form name='signIn' method='post' action='signIn.php'>
					<input type='text' name='id' /> <br>
					<input type='password' name='passwd' /> <br>
					<input type='submit' name='signIn' value='로그인' />
					<input type='submit' name='signUp' value='가입하기' />
				</form>
			";
        ?>
	</body>
</html>