<!-- 로그인 및 회원가입 -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    </meta>
	<title>로그인</title>
    <link rel="icon" href="../asset/favicon.ico" />

	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
	<!-- MDB -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.css" rel="stylesheet" />

	<!-- MDB -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.js"></script>

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

	# 탈퇴하기.
	if (isset($_POST['leave'])) {
		# 사용자 검사.
		$user = $userRepo->getUserById($_POST['id']);

		# 사용자가 없거나 아이디 또는 비밀번호를 입력하지 않았으면 아무 것도 하지 않음.
		if (!$user || !$_POST['id'] || !$_POST['passwd']) {
			header('Location: signIn.php');
			return;
		}

		# 비밀번호가 일치하지 않으면 아무 것도 하지 않음.
		if ($user['passwd'] != $_POST['passwd']) {
			header('Location: signIn.php');
			return;
		}

		# 사용자 삭제 및 확인 메시지 출력.
		$userRepo->deleteUser($_POST['id'], $_POST['passwd']);
		LogUtil::alert('탈퇴되었습니다.');
	}
	?>

	<!-- 사용자 정보 입력 폼 -->
	<section class="vh-100" style="background-color: #ffffff;">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card shadow-2-strong" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">
							<form name='signIn' action='signIn.php' method='post'>
								<h3 class="mb-5">로그인</h3>

								<div class="form-outline mb-4">
									<input type="text" name='id' class="form-control form-control-lg" />
									<label class="form-label">아이디</label>
								</div>

								<div class="form-outline mb-4">
									<input type="password" name='passwd' class="form-control form-control-lg" />
									<label class="form-label">비밀번호</label>
								</div>

								<button class="btn btn-primary btn-lg btn-block" type="submit" name='signIn'>로그인</button>

								<hr class="my-4">

								<button class="btn btn-primary btn-lg btn-block" type="submit" name='signUp'>가입하기</button>
								<button class="btn btn-primary btn-lg btn-block btn-danger" type="submit" name='leave'>탈퇴하기</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

</html>
