<?php 
	session_start();
	if ($_SESSION['user']) {
		header('Location: main_authorized.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Authorization</title>
	<link rel="stylesheet" href="/styles/auth.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>
	<div class="backplateforauth">
		<form action="vendor/login.php" method="post">
			<label>Логин</label>
			<input type="text"  name="login" placeholder="Введите логин">
			<label>Пароль</label>
			<input type="password" name="password"placeholder="Введите пароль">
			<button type="submit">Войти</button>
			<p>У Вас нет аккаунта? - <a href="registration.php">Зарегистрируйстесь</a>!</p>
			<?php 
				if ($_SESSION['message']) {
					echo '<p class="errors">'.$_SESSION['message'].'</p>';
					}	
				unset($_SESSION['message'])
			?>
		</form>
	</div>
</body>
</html>