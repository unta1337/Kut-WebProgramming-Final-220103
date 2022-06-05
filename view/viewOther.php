<!-- 다른 사용자의 할 일 목록 조회 -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	</meta>
	<title>Other's To Do</title>

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
	$other = $_SESSION['other'];

	# 이전 화면으로 돌아가기.
	if (isset($_POST['return'])) {
		header('Location: index.php');
		return;
	}
	?>

	<section class="vh-100" style="background-color: #ffffff;">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col col-lg-9 col-xl-7">
					<div class="card shadow-2-strong" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">

							<form name="logOut" action="index.php" method="post">
								<h1 class="text-center my-3 pb-3"><?= $user['id'] ?>
									<div class="form-outline">
										<button type="submit" name="return" class="btn btn-outline-primary">돌아가기</button> <br>
									</div>
								</h1>
							</form>

							<table class="table mb-4">
								<thead>
									<tr>
										<th scope="col">할 일</th>
										<th scope="col">상태</th>
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
												echo "<td>완료</td>";
											} else {
												echo "<td>미완료</td>";
											}
											?>
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