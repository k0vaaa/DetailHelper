<?php
require_once 'connect.php';
$query = $_POST['model'];
if ($query and $query!='Все бренды') {
    $result5 = mysqli_query($connect, "SELECT `nameofmodel`,`id_model` FROM `productinfo` WHERE `brand` = '$query'ORDER BY `nameofmodel`");
}
else {
    $result5 = mysqli_query($connect,"SELECT * FROM `model` ORDER BY `nameofmodel`");
}
$products5 = array();
while ($productInfo5 = $result5->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
    $products5[] = $productInfo5;

};
echo(json_encode($products5));