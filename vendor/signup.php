<?php 
	session_start();
	require_once 'connect.php';

	$full_name=$_POST['fullname'];
	$login=$_POST['login'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$passwordcheck=$_POST['passwordcheck'];

if ($password===$passwordcheck) {
	
	$password=md5($password);

	mysqli_query($connect,"INSERT INTO `users`(`id_user`, `fullname`, `login`, `email`, `password`) 
		VALUES (NULL,'$full_name','$login','$email','$password')");
	
	$_SESSION['message'] = 'Регистрация прошла успешно!';
	header('Location: ../main_authorized.php'); 

} else {
	$_SESSION['message'] = 'Пароли не совпадают';
	header('Location: ../registration.php');
}
	
?>

