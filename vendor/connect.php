<?php
	$connect = mysqli_connect('localhost','root','','market1');
	if (!$connect) {
		die('Ошибка подключения к базе данных.');
	}