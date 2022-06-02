<?php 
	session_start();
	require_once 'vendor/connect.php';
require_once 'vendor/querytodatabase.php';
	if (!$_SESSION['user']) {
		header('Location: authorization.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DetailHelper</title>
    <link rel="icon" type="image/jpg" href="content/favicon.jpg">
    <link rel="stylesheet" href="/styles/main.css"> <!--подключение файла стилей-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>
<a href="" class="back-to-top">
    <img src="content/arrow.png">
</a>
<header class="header"> <!-- контейнер "шапка", содержащий навигацию-->
    <div class="header_section">
        <div class="header_item logo">
            <img src="content/favicon.jpg" alt="" width="50" height="50">
            <h1 id="logotitle">Detail Helper</h1> <!--убрать h1-->
        </div>
    </div>
    <div class="header_section">
        <div class="header_item">
            <a href="#secondblock">Каталог</a>
        </div>
        <div class="header_item">
            <ul class="menu__list">
                <li>
                    <a href="" class="menu__link"><?= $_SESSION['user']['login']?></a>
                    <ul class="sub-menu__list">
                        <li>
                            <a href="profile.php" class="sub-menu__link" id="profile">Личный кабинет</a>
                        </li>
                        <li>
                            <a href="vendor/logout.php" class="sub-menu__link" id="exit">Выход</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="header_item">
            <a href="#about">О нас</a>
        </div>
        <div class="header_item">
            <a id="headercarttrigger">Корзина</a>
            <div class="headercart">
                <div class="headercart__body">
                    <h1>Состав корзины</h1>
                    <div class="emptyheadercart"></div>
                    <div class="headercart__body__content">
                        <table id="cart_table">
                            <thead>
                            <tr id="tabletitle">
                                <th id="title__table__name">Наименование</th>
                                <th id="title__table__price">Цена за ед.
                                    (руб.)</th>
                                <th id="title__table__count">Количество</th>
                            </tr>
                            </thead>
                            <tbody class="carttableout"> </tbody>
                        </table>
                        <div class="tablesum">
                            Итог: <span class="summa"></span>.<sup>00</sup> &#8381
                        </div>
                        <div class="orderheaderbtns">
                            <a id="button1">Быстрый заказ</a>
                            <button id="button2">Оформить заказ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="firstblock" class="block"> <!--Верхний блок страницы-->
    <h1>Приветствуем Вас, <?=$_SESSION['user']['login']?>!</h1>
    <p>Выбирайте товары для Вашего авто быстро и удобно!</p>
    <a id="tocatalog">В каталог</a>
</div>
<div id="secondblock" class="block"><!-- Каталог -->
    <h1 id="catalog__title">Каталог товаров</h1>
    <div class="catalog">
        <div class="filter">
            <h1 id="filter__title">Фильтры</h1>
            <!--            <div class="filters">-->
            <!--                <p>Сортировка товаров:</p>-->
            <!--                <button type="button" data-sort="price:asc">Сортировка по цене (по возрастанию)</button>-->
            <!--                <button type="button" data-sort="price:desc">Сортировка по цене (по убыванию)</button>-->
            <!--                <button type="button" data-sort="name:asc">Сортировка по бренду (A->Z)</button>-->

            <!--            </div>-->
            <div class="select">
                <div class="select__header">
                    <span class="select__current">Бренд</span>
                    <div class="select__icon" id="icon"><img id="arrowfilter" src="content/arrowfilter.png"></div>
                </div>

                <div class="select__body">
                    <? foreach ($products1 as $product1):?>
                        <div class="select__item" data-filter=".category-<?=$product1['brand']?>"><?=$product1['brand']?></div>
                    <?endforeach?>

                    <div class="select__item" data-filter="all">Все бренды</div>
                </div>
            </div>

        </div>


        <div class="goods"> <!--Класс функционального блока вывода товаров-->
            <div class="sort">
                <p id="changesorttitle">Сортировка не выбрана</p>
                <div class="sortimgs">
                    <img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">
                    <img src="content/pricehightolow.png" id="pricehightolow" data-sort="price:desc">
                    <img src="content/nameatoz.png" id="nameatoz" data-sort="name:asc">
                    <img src="content/nameztoa.png" id="nameztoa" data-sort="name:desc">
                    <img src="content/randomsort.png" id="random" data-sort="random">
                </div>
            </div>
            <div class="cards">
                <?php foreach ($products2 as $product2):?> <!--цикл на формирование уникальных карточек-->
                    <div class="card mix category-<?=$product2['brand']?>"  method="post"
                         data-price="<?=$product2['price']?>" data-name="<?=$product2['brand']?>"> <!--"Макет" карточки товара-->
                        <img src="/content/<?=$product2['pathtoimg']?>">
                        <p id="name"><?=$product2['name']?></p>
                        <p id="brandmodel"><?=$product2['brand']?> <?=$product2['model']?></p>
                        <p id="price"><?=$product2['price']?>.<sup>00</sup> &#8381 </p>
                        <p id="quantity">В наличии: <?=$product2['quantity']?> шт.</p>
                        <button type="submit" class="add-to-cart" data-id="<?=$product2['id_product']?>"
                                data-name="<?=$product2['name']?>" data-price="<?=$product2['price']?>" data-brand="<?=$product2['brand']?>" data-model="<?=$product2['model']?>">Заказать</button>
                        <p><a id="more" href="#popup_more<?=$product2['id_product']?>" data-name="<?=$product2['name']?>">подробнее</a></p>
                        <div id="popup_more<?=$product2['id_product']?>" class="popup"> <!--Всплывающее окно карточки товара-->
                            <a href="#header" class="popup__area"></a>
                            <div class="popup__body">
                                <div class="popup__content">
                                    <div class="popup__title" id="card__title"><?=$product2['name']?></div>
                                    <div class="popup__fill">
                                        <div class="columns">
                                            <img src="/content/<?=$product2['pathtoimg']?>">
                                            <div class="specs">
                                                <p><b>Марка: </b><?=$product2['brand']?></p>
                                                <p><b>Модель: </b><?=$product2['model']?></p>
                                                <p><b>Артикул: </b><?=$product2['articul']?></p>
                                                <p><b>Наличие: </b><?=$product2['quantity']?> шт.</p>
                                                <p><b>Категория: </b><?=$product2['categoryname']?></p>
                                                <br>
                                                <p id="money"><b>Цена: </b><?=$product2['price']?>.<sup>00</sup> &#8381 <? if ($product2['quantity']>0){?>
                                                    <button id="popuporderbtn" type="submit" class="add-to-cart" data-id="<?=$product2['id_product']?>"
                                                            data-name="<?=$product2['name']?>" data-price="<?=$product2['price']?>" data-brand="<?=$product2['brand']?>" data-model="<?=$product2['model']?>">Заказать</button><?
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                        <p id="descr"><?=$product2['description']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?endforeach?>
            </div>
        </div>
    </div>
</div>
<div id="thirddblock" class="block"> <!--Блок со справочной информацией-->
    *справочная информация*
</div>
<footer>Подвал страницы</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!--Скрипт на подключение к библиотеке JQuery-->
<script src=" /scripts/mixitup.min.js "></script> <!--Скрипт подлкючения файла библиотеки MixItUp-->
<script src="/scripts/index.js"></script> <!--Подключение основного JS файла к документу-->
</body>
</html>




	