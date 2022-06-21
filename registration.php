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
	<title>Registration</title>
    <link rel="icon" type="image/svg" href="content/logo.svg">
	<link rel="stylesheet" href="/styles/auth.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>
	<div class="backplateforreg">
        <div class="logo">
            <img src="content/logo.svg" alt="">
            <h1 id="logotitle">Detail Helper</h1>
        </div>
		<form action="vendor/signup.php"method="post">
			<label>ФИО</label>
			<input type="text" name="fullname" placeholder="Введите ваше полное имя">
			<label>Логин</label>
			<input type="text" name="login" placeholder="Введите логин">
			<label>Почта</label>
			<input type="email"name="email" placeholder="Введите адрес вашей почты">
			<label>Пароль</label>
			<input type="password" name="password" placeholder="Введите пароль">
			<label>Повтор пароля</label>
			<input type="password" name="passwordcheck"  placeholder="Повторите пароль">
			<button type="submit">Регистрация</button>
			<p>У Вас уже есть аккаунт? - <a href="authorization.php">Авторизируйтесь</a>!</p>
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