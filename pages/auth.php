<?php

$error = '';

if (isset($_POST['auth'])) {
	
	$db_query = mysqli_query($instance->conn, "select * from user where login like '".$_POST['login']."' and pass like '".$_POST['pass']."'");
	$db_query_res = mysqli_fetch_assoc($db_query);
	
	if ($db_query_res) {
		$_SESSION['user_in'] = true;
		$_SESSION['user_name'] = $db_query_res['login'];
		$instance->redirect('/diplom');
	} else {
		$error = 'Неправильный логин или пароль';
	}
		
}

if (isset($_GET['act'])) {
	if ($_GET['act'] == 'logout') {
		session_destroy();
	}
}

if (isset($_GET['goto'])) {
		$location = $_GET['goto'];
}

?>

<!doctype html>

<head>
</head>
	<title>Диплом</title> 
	<link rel="shortcut icon" href="">
	<link rel="stylesheet" href="/diplom/css/style.css">
<body>
					
					<div class="container">
					<div class="login-cont">
						<div class="login">

						<h2 class="auth-error"><?if($error) echo $error;?></h2>

						<form action="" method="post" class="auth-form">
							<p><input class="auth" type="text" name="login" placeholder="Логин" value="<?=@$_POST['login']?>"/></p>
							<p><input class="auth" type="password" name="pass" placeholder="Пароль" value="<?=@$_POST['pass']?>"/></p>
							<p><input class="sub" type="submit" name="auth" value="Авторизация"/></p>
						</form>
						<div class="clearer"></div>

						
						</div>
					</div>
					
</body>					

</html>