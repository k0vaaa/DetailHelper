<?php
session_start();
require_once '../vendor/connect.php';

$a = $_POST['login'];

$b = $_POST['name'];

$c = $_POST['email'];

$d = $_POST['receivecart'];

$e = $_POST['totalsumm'];

$datetime = date('Y.m.d H:i:s');




if (!$_SESSION['user']){
    $order = mysqli_query($connect, "INSERT INTO `orders`(`id_order`, `id_user`, `total_price`, `date`)
 VALUES (NULL,NULL,'$e', '$datetime')");
}
else {
    $id_user = $_SESSION['user']['id_user'];
    $order = mysqli_query($connect, "INSERT INTO `orders`(`id_order`, `id_user`, `total_price`, `date`)
 VALUES (NULL,'$id_user','$e', '$datetime')");
}
    $lastid = mysqli_insert_id($connect);


$output = "<!DOCTYPE html><html lang='ru'><head><meta charset='UTF-8'></head><body><table>";
$orderproducts = "";
$stock = "";
$someObject = json_decode($d);
echo "<pre>";
$decodeonce = json_decode($someObject);


foreach ($decodeonce as $i) {
    $output .= "<tr><td>{$i->good->name}</td><td>{$i->good->price} руб. </td><td>{$i->good->count} шт.</td></tr>";
    $orderproducts = mysqli_query($connect, "INSERT INTO `order_products`(`id_order`, `id_product`, `quantity`, `price`) 
VALUES ($lastid,{$i->id},{$i->good->count},'{$i->good->price}')");
    $stock = mysqli_query($connect, "UPDATE `product` SET `quantity` = `quantity` - {$i->good->count} WHERE `id_product` = {$i->id}");

}
$output .= "</table></body></html>";

require_once('phpmailer/PHPMailerAutoload.php');

$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';      // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'jspython.project007@gmail.com'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = 'whqsudngbguarqxi';
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;

$mail->setFrom('jspython.project007@gmail.com'); // от кого будет уходить письмо?
$mail->addAddress($c);     // Кому будет уходить письмо

$mail->isHTML(true);     // Set email format to HTML

$mail->Subject = 'Заявка на бронь DetailHelper';
$mail->Body = '';
$mail->msgHTML("<html><body>
               
                <p> $b, благодарим Вас за заказ на DetailHelper. Его номер: $lastid</p>
                <p>Состав вашего заказа: $output</p>
                <p>Итоговая сумма забронированных товаров: $e рублей.</p>
                </html></body>");

if (!$mail->send()) {
    echo 'Error';
} else {
    header('Location: /form-lesson/thank-you.php');
}