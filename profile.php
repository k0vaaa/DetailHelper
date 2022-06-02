<?php
session_start();
require_once 'vendor/connect.php';
if (!$_SESSION['user']) {
    header('Location: authorization.php');
}
$id_user = $_SESSION['user']['id_user'];
$result = mysqli_query($connect,"SELECT `id_order`, `total_price`, `date`,`id_user` FROM `orders` WHERE `id_user` = '$id_user'");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&
	family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&family=
	Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>

<header class="header"> <!-- контейнер "шапка", содержащий навигацию-->
    <div class="header_section">
        <div class="header_item logo">
            <img src="content/favicon.jpg" alt="" width="50" height="50">
            <h1 id="logotitle">Detail Helper</h1> <!--убрать h1-->
        </div>
    </div>
    <div class="header_section">
        <div class="header_item">
            <a href="../main_authorized.php#secondblock">Каталог</a>
        </div>
        <div class="header_item">
            <a href="../main_authorized.php#thirddblock">О нас</a>
        </div>

    </div>
</header>

<div class="backpic">
    <div class="containerforprof">
        				<h1 id="profiletitle">Личный кабинет</h1>
        <div class="profile">
            <div class="info">
                <p id="infotitle">Учетная запись</p>
                <p>Логин:</p><span><?=$_SESSION['user']['login']?></span>
                <p>ФИО:</p><span><?=$_SESSION['user']['fullname']?></span>
                <p>E-mail:</p><span><?=$_SESSION['user']['email']?></span>
                <a id="quit" href="vendor/logout.php">Выход</a>
            </div>
            <div class="history">
                <p id="historytitle">История заказов</p>
                <p id="historydescr">Здесь вы можете увидеть совершенные ранее заказы.</p>
                <div class="historyoutput">
                <?php
                if (mysqli_num_rows($result)==0){
                    ?><p>Пока что история Ваших заказов пуста. Здесь появится информация о заказе как только вы его совершите.</p><?
                }
                else {
                    ?>
                    <div class="table_responsive1">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><div>Номер заказа</div></th>
                                <th><div>Итоговая сумма (руб.)</div></th>
                                <th><div>Дата и время</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            while ($orderInfo = $result->fetch_assoc()){
                                $orders[0] = $orderInfo;
                                foreach ($orders as $order):?>
                                    <tr>
                                        <td><?echo($order['id_order']);?></td>
                                        <td><?echo($order['total_price']);?>.<sup>00</sup> &#8381 </td>
                                        <td><?echo($order['date']);?></td>
                                    </tr>
                                <?endforeach;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?
                }
                ?>
            </div>
            </div>
            <div class="order">
                <p id="ordertitle">Содержимое корзины</p>
                <p id="orderdescr">Данный инструмент позволяет изменять содержимое корзины.</p>
                <div class="zakaz no">
                    <div class="orderoutput">
                        <div class="table_responsive2">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Марка</th>
                                    <th>Модель</th>
                                    <th>Цена (руб.)</th>
                                    <th>Количество</th>
                                </tr>
                                </thead>
                                <tbody class="elements">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <p id="emptycart">Корзина пуста, обратитесь к нашему <a id="empycartlink" href="main_authorized.php">каталогу</a> !</p>
            </div>

        </div>
        <div class="ordermenu no">

            <a href="#popup3" id="one">Оформить</a>
            <a href="#popup2" id="two">Удалить</a>
            <a href="#popup1" id="three">Изменить</a>
        </div>
        <div id="popup1" class="popup">
            <a href="#header" class="popup__area"></a>
            <div class="popup__body">
                <div class="popup__content">
                    <a href="#header" class="popup__close">X</a>
                    <div class="popup__title">Изменение заказа</div>
                    <div class="popup__fill">
                        <div class="basket"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup2" class="popup">
            <a href="#header" class="popup__area"></a>
            <div class="popup__body">
                <div class="popup__content">
                    <a href="#header" class="popup__close">X</a>
                    <div class="popup__title">Удаление заказа</div>
                    <div class="popup__fill">
                        Вы уверены, что хотите удалить ВЕСЬ заказ?
                        <div class="popup__buttons">
                            <button class="dell-all">Да, удалить заказ.</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup3" class="popup">
            <a href="#header" class="popup__area"></a>
            <div class="popup__body">
                <div class="popup__content">
                    <a href="#header" class="popup__close">X</a>
                    <div class="popup__title">Оформление заказа</div>
                    <div class="popup__fill">
                        <form action="/form-lesson/mail.php"  method="post">
                            <input value="<?=$_SESSION['user']['login']?>" name="login" type="text">
                            <input value="<?=$_SESSION['user']['fullname']?>" name="name" type="text">
                            <input value="<?=$_SESSION['user']['email']?>" name="email" type="text">
                            <input type="text" name="receivecart" value="" class="meow">
                            <input type="text" name="totalsumm" value="" class="meow">
                            <button type="submit" name="submit-btn" class="formsend">Оформить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/scripts/cart.js"></script>
</body>
</html>