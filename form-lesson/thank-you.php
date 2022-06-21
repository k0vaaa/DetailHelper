<?php
session_start();
require_once '../vendor/connect.php';

if ($_SESSION['user']){
    header("Refresh: 3; url=../profile.php");
}
else {
    header("Refresh: 3; url=../main.php");
}
$meow = $lastid;
//$id_user = $_SESSION['user']['id_user'];
//$datetime = date('Y.m.d H:i:s');
//$getnum = mysqli_query($connect, "SELECT `id_order`FROM `orders` WHERE `id_user` = '$id_user' AND `id_order`=WHERE id=LAST_INSERT_ID()");
//if (mysqli_num_rows($getnum)==0){
//    echo '1';
//}
//else {
//    echo '2';
//}
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
      <link rel="icon" type="image/svg" href="content/logo.svg">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
      <style>
          .container {
              text-align: center;
              font-family: Montserrat, Arial, sans-serif;
              color: #000000;
          }
          h1 {
              font-size:3em;
          }
          p {
              font-size:2em;
          }

      </style>
    <title>Отправка формы на почту </title>


  </head>

  <body>
    <div class="container">

      <h1 class="text-center">Благодарим за заказ!</h1>
        <p>Через 3 секунды вы будете перенаправлены в личный кабинет.</p>
        <p>Если этого не произошло, нажмите на <a href="../profile.php">ссылку</a>.</p>
        <div class="formsend"></div>
        <div id="result"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../scripts/cart.js"></script>
    <script>
        localStorage.clear();
        loadCart();
    </script>
  </body>
</html>




	