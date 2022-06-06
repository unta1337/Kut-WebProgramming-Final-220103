<!-- 메인 페이지 -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    </meta>
	<title>할 일</title>
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

	# 할 일 추가.
	if (isset($_POST['addTask'])) {
		$taskRepo->addTask($_POST['content'], $user['id_uniq']);
	}

	# 할 일 삭제.
	if (isset($_POST['deleteTask'])) {
		$taskRepo->deleteTask($_POST['deleteTask']);
		header('Location: index.php');
	}

	# 완료로 표시.
	if (isset($_POST['flipDone'])) {
		$taskRepo->flipDone($_POST['flipDone']);
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
	?>

	<section class="vh-100" style="background-color: #ffffff;">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col col-lg-9 col-xl-7">
					<div class="card shadow-2-strong" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">

							<form name="logOut" action="index.php" method="post">
								<h1 class="text-center my-3 pb-3"><?= TextUtil::asPlainText($user['id']) ?>
									<div class="form-outline">
										<button type="submit" name="logOut" class="btn btn-outline-primary">로그아웃</button> <br>
									</div>
								</h1>
							</form>

							<form name="viewOther" action="index.php" method="post" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
								<div class="col-12">
									<div class="form-outline">
										<input type="text" name="otherUser" id="form1" class="form-control" />
										<label class="form-label" for="form1">사용자 이름</label>
									</div>
								</div>

								<div class="col-12">
									<button type="submit" name="viewOther" class="btn btn-primary">조회</button>
								</div>
							</form>

							<form name="addTask" action="index.php" method="post" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
								<div class="col-12">
									<div class="form-outline">
										<input type="text" name="content" id="form1" class="form-control" />
										<label class="form-label" for="form1">할 일 입력</label>
									</div>
								</div>

								<div class="col-12">
									<button type="submit" name="addTask" class="btn btn-primary">확인</button>
								</div>
							</form>

							<table class="table mb-4">
								<thead>
									<tr>
										<th scope="col">할 일</th>
										<th scope="col">상태</th>
										<th scope="col">액션</th>
									</tr>
								</thead>

								<?php
								$result = $taskRepo->getTasksByAuthor($user['id']);
								echo "<br>";
								foreach ($result as $row) {
								?>
									<tbody>
										<tr>
											<td><?= TextUtil::asPlainText($row['task']) ?></td>
											<?php
											if ($row['is_done']) {
												echo "<td>완료됨</td>";
											} else {
												echo "<td>진행중</td>";
											}
											?>
											<form name="task" action="index.php" method="post">
												<td>
													<button type="submit" name="deleteTask" value=<?= $row['task_id'] ?> class="btn btn-danger">삭제</button>
													<button type="submit" name="flipDone" value=<?= $row['task_id'] ?> class="btn btn-success ms-1">완료</button>
												</td>
											</form>
										</tr>
									</tbody>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

</html>
