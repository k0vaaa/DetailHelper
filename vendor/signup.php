<?php 
	session_start();
	require_once 'connect.php';

	$full_name=$_POST['fullname'];
	$login=$_POST['login'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$passwordcheck=$_POST['passwordcheck'];

if ($password===$passwordcheck) {

	$result1 = mysqli_query($connect,"SELECT `login` FROM `users`
		WHERE `login`='$login'");

	$row_cnt1 = $result1->num_rows;

	if ($row_cnt1 == 0){
		$result2 = mysqli_query($connect,"SELECT `email` FROM `users`
		WHERE `email`='$email'");

		$row_cnt2 = $result2->num_rows;
		if ($row_cnt2 == 0){

			$password=md5($password);

			mysqli_query($connect,"INSERT INTO `users`(`id_user`, `fullname`, `login`, `email`, `password`) 
		VALUES (NULL,'$full_name','$login','$email','$password')");

			$_SESSION['message'] = 'Регистрация успешна!';
			header('Location: ../main_authorized.php');

		}
		else {
			$_SESSION['message'] = 'E-mail уже используется!';
			header('Location: ../registration.php');
		}
	}
	else {
		$_SESSION['message'] = 'Логин занят!';
		header('Location: ../registration.php');
	}
}
else {
	$_SESSION['message'] = 'Пароли не совпадают!';
	header('Location: ../registration.php');
}
	
?>

