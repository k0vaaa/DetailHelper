<?php
require_once 'connect.php';
$result1 = mysqli_query($connect,"SELECT DISTINCT `brand` FROM `productinfo` ORDER BY brand");
$products1 = array();
while ($productInfo1 = $result1->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
    $products1[] = $productInfo1;
};

//$result2 = mysqli_query($connect,"SELECT * FROM `productcategory` WHERE `quantity`>0"); /*Запрос на выборку товаров из базы*/
//$products2 = array();
//while ($productInfo2 = $result2->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
//    $products2[] = $productInfo2;
//};


$result3 = mysqli_query($connect,"SELECT * FROM `category` ORDER BY categoryname"); /*Запрос на выборку товаров из базы*/
$products3 = array();
while ($productInfo3 = $result3->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
    $products3[] = $productInfo3;
};

$result4 = mysqli_query($connect,"SELECT * FROM `productinfo` WHERE `quantity`> 0"); /*Запрос на выборку товаров из базы*/
$products4 = array();
while ($productInfo4 = $result4->fetch_assoc()) { /*обрабатывающий цикл для преобразования полученных данных из запроса*/
    $products4[] = $productInfo4;
};


