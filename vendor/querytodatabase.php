<?php
require_once 'connect.php';
$result1 = mysqli_query($connect,"SELECT DISTINCT `brand` FROM `product`");
$products1 = array();
while ($productInfo1 = $result1->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
    $products1[] = $productInfo1;
};

$result2 = mysqli_query($connect,"SELECT * FROM product"); /*Запрос на выборку товаров из базы*/
$products2 = array();
while ($productInfo2 = $result2->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
    $products2[] = $productInfo2;
};

