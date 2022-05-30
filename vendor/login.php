<?php 
	session_start();
	require_once 'connect.php';

	$login=$_POST['login'];
	$password=md5($_POST['password']);

	$checkuser = mysqli_query($connect,"SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
	if (mysqli_num_rows($checkuser)>0) {

		$user = mysqli_fetch_assoc($checkuser);

		$_SESSION['user'] = [
			"id_user" => $user['id_user'],
			"login" => $user['login'],
			"fullname" => $user['fullname'],
			"email" => $user['email']
		];
		header('Location: ../main_authorized.php');

	} else {
		$_SESSION['message'] = 'Неверный логин или пароль';
		header('Location: ../authorization.php');
	}
