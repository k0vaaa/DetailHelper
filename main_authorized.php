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
    <meta charset="utf-8"> <!--указание кодировки документа -->
    <title>DetailHelper</title>
    <link rel="icon" type="image/svg" href="content/logo.svg">
    <link rel="stylesheet" href="/styles/main.css"> <!--подключение файла стилей-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap"
    rel="stylesheet">
</head>
<body>
<a href="" class="back-to-top">
    <img src="content/arrow.png">
</a>
<header class="header"> <!-- контейнер "шапка", содержащий навигацию-->
    <div class="header_section">
        <div class="header_item_ logo">
            <img src="content/logo.svg" alt="" width="50" height="50">
            <h1 id="logotitle">Detail Helper</h1> <!--убрать h1-->
        </div>
    </div>
    <div id="anchors" class="header_section">
        <div class="header_item">
            <a id="tocatalog1"href="#secondblock">Каталог</a>
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
<!--        <div class="header_item">-->
<!--            <a id="toinfo" href="#thirddblock">О нас</a>-->
<!--        </div>-->
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
                    </div>
                        <div class="tablesum">
                            Итог: <span class="summa"></span>.<sup>00</sup> &#8381
                        </div>

                        <div class="orderheaderbtns">
                            <a id="buttontoprof" href="profile.php">Оформить заказ</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="firstblock" class="block"> <!--Верхний блок страницы-->
    <h1>Приветствуем Вас, <?= $_SESSION['user']['login']?>!</h1>
    <p>Выбирайте товары для Вашего авто быстро и удобно!</p>
    <a id="tocatalog2">В каталог</a>
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
            <div class="select" id="filterbrand">
                <div class="select__header" id="headerbrand">
                    <span class="select__current">Все бренды</span>
                    <div class="select__icon" id="icon"><img id="arrowfilter" src="content/arrowfilter.png"></div>
                </div>

                <fieldset data-filter-group class="select__body">
                    <? foreach ($products1 as $product1):?>
                        <div class="select__item" data-filter=".<?=$product1['brand']?>"><?=$product1['brand']?></div>
                    <?endforeach?>

                    <div class="select__item" data-filter="">Все бренды</div>
                </fieldset>
            </div>
            <div class="select" id="filtercategory">
                <div class="select__header" id="headercategory">
                    <span class="select__current">Все категории</span>
                    <div class="select__icon" id="icon"><img id="arrowfilter" src="content/arrowfilter.png"></div>
                </div>

                <fieldset data-filter-group class="select__body">
                    <? foreach ($products3 as $product3):?>
                        <div class="select__item" data-filter=".c<?=$product3['id_category']?>"><?=$product3['categoryname']?></div>
                    <?endforeach?>

                    <div class="select__item" data-filter="">Все категории</div>
                </fieldset>
            </div>
            <div class="select" id="filtermodel">
                <div class="select__header" id="headermodel">
                    <span class="select__current">Все модели</span>
                    <div class="select__icon" id="icon"><img id="arrowfilter" src="content/arrowfilter.png"></div>
                </div>

                <fieldset data-filter-group class="select__body" id="modelfilter">
                    <div class="select__item"  data-filter=""></div>
                </fieldset>
            </div>
            <!--            <div class="select">-->
            <!--                <div class="select__header">-->
            <!--                    <span class="select__current">Категория</span>-->
            <!--                    <div class="select__icon" id="icon"><img id="arrowfilter" src="content/arrowfilter.png"></div>-->
            <!--                </div>-->
            <!---->
            <!--                <div class="select__body">-->
            <!--                    --><?// foreach ($products3 as $product3):?>
            <!--                        <div class="select__item" data-filter=".category---><?//=$product3['categoryname']?><!--">--><?//=$product3['categoryname']?><!--</div>-->
            <!--                    --><?//endforeach?>
            <!---->
            <!--                    <div class="select__item" data-filter="all">Все бренды</div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>


        <div class="goods"> <!--Класс функционального блока вывода товаров-->
            <div class="sort">
                <p id="changesorttitle">Сортировка не выбрана</p>
                <!-- <form id="searchform" action=""><input id="searchinput" type="search" name="q" placeholder="Поиск по VIN"><button id="searchbutton" type="submit" value="">Найти</button></form>-->
                <div class="sortimgs">
                    <div class="pricelowtohighclass" data-sort="price:asc"><img class="pricelowtohigh" src="content/pricelowtohigh2.png"></div>
                    <div class="pricehightolowclass" data-sort="price:desc"> <img class="pricehightolow" src="content/pricehightolow2.png"></div>
                    <div class="nameatozclass" data-sort="name:asc"><img class="nameatoz" src="content/nameatoz2.png"></div>
                    <div class="nameztoaclass" data-sort="name:desc"><img class="nameztoa" src="content/nameztoa2.png"></div>
                </div>
            </div>
            <div class="cards">
                <?php foreach ($products4 as $product4):?> <!--цикл на формирование уникальных карточек-->
                    <div class="card mix <?=$product4['brand']?> c<?=$product4['id_category']?> m<?=$product4['id_model']?>" method="post"
                         data-price="<?=$product4['price']?>" data-name="<?=$product4['brand']?>"> <!--"Макет" карточки товара-->
                        <img src="/content/<?=$product4['pathtoimg']?>">
                        <p id="name"><?=$product4['name']?></p>
                        <p id="brandmodel"><?=$product4['brand']?> <?=$product4['nameofmodel']?></p>
                        <p id="price"><?=$product4['price']?>.<sup>00</sup> &#8381 </p>
                        <p id="quantity">В наличии: <?=$product4['quantity']?> шт.</p>
                        <button type="submit" class="add-to-cart" data-id="<?=$product4['id_product']?>"
                                data-name="<?=$product4['name']?>" data-price="<?=$product4['price']?>" data-brand="<?=$product4['brand']?>" data-model="<?=$product4['nameofmodel']?>" data-quantity="<?=$product4['quantity']?>">Заказать</button>
                        <p><a id="more" href="#popup_more<?=$product4['id_product']?>" data-name="<?=$product4['name']?>">подробнее</a></p>
                        <div id="popup_more<?=$product4['id_product']?>" class="popup"> <!--Всплывающее окно карточки товара-->
                            <a href="#header" class="popup__area"></a>
                            <div class="popup__body">
                                <div class="popup__content">
                                    <div class="popup__title" id="card__title"><?=$product4['name']?></div>
                                    <div class="popup__fill">
                                        <div class="columns">
                                            <img src="/content/<?=$product4['pathtoimg']?>">
                                            <div class="specs">
                                                <p><b>Марка: </b><?=$product4['brand']?></p>
                                                <p><b>Модель: </b><?=$product4['nameofmodel']?></p>
                                                <p><b>Артикул: </b><?=$product4['articul']?></p>
                                                <p><b>Наличие: </b><?=$product4['quantity']?> шт.</p>
                                                <p><b>Категория: </b><?=$product4['categoryname']?></p>
                                                <br>
                                                <p id="money"><b>Цена: </b><?=$product4['price']?>.<sup>00</sup> &#8381 <? if ($product4['quantity']>0){?>
                                                    <button id="popuporderbtn" type="submit" class="add-to-cart" data-id="<?=$product4['id_product']?>"
                                                            data-name="<?=$product4['name']?>" data-price="<?=$product4['price']?>" data-brand="<?=$product4['brand']?>" data-model="<?=$product4['nameofmodel']?>" data-quantity="<?=$product4['quantity']?>">Заказать</button><?
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                        <p id="descr"><?=$product4['description']?></p>
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
<div class="block" id="thirdblock">
    <h1 id="about">О нас</h1>
    <div class="infoblock">
        <div class="answers">
            <h1>Cправочная информация</h1>
            <div class="list-group">
                <div class="list-group-item list-header" data-name="spoiler-title">
                    Как оформить заказ?
                </div>
                <div class="list-group-item list-content spoiler-body">
                    Для оформления заказа перейдите к каталогу, выберите интересующий Вас товар и нажмите "Заказать", после чего откройте корзину для проверки наличия товара.
                </div>
                <div class="list-group-item list-header" data-name="spoiler-title">
                    Как работает функция "быстрого" заказа?
                </div>
                <div class="list-group-item list-content spoiler-body">
                    Наш сервис предоставляет возможность оформить быстрый заказ при условии, если в корзине содержится суммарно не более трёх единиц товаров. Для оформления такого заказа достаточно ввести ФИО, почту и номер телефона.
                </div>
                <div class="list-group-item list-header" data-name="spoiler-title">
                    Для чего нужна регистрация на сайте?
                </div>
                <div class="list-group-item list-content spoiler-body">
                    Прохождение регистрации обеспечивает наших пользователей информацией об истории совершенных заказов.
                </div>
                <div class="list-group-item list-header" data-name="spoiler-title">
                    Как происходит процедура оплаты и получения заказа?
                </div>
                <div class="list-group-item list-content spoiler-body">
                    После оформления заказа пользователем на выбранные товары накладывается бронь. Далее, при посещении склада клиент может осмотреть и оплатить товар.
                </div>
            </div>
        </div>
        <div class="map">
            <div class="yandex" style="position:relative;overflow:hidden;">
                <!--                <a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Москва</a>-->
                <!--                <a href="https://yandex.ru/maps/213/moscow/?ll=37.622504%2C55.753215&utm_medium=mapframe&utm_source=maps&z=10" style="color:#eee;font-size:12px;position:absolute;top:14px;">Яндекс Карты — транспорт, навигация, поиск мест</a>-->
                <iframe src="https://yandex.ru/map-widget/v1/-/CCQhr2cIxD" width="400" height="400" frameborder="0" style="position:relative; border-radius: 15px;"></iframe>
            </div>
            <div class="abouttext">
                <h1 id="geo">Адрес склада</h1>
                <p>г. Москва, Тверская улица, дом 13</p>
                <h1 id="workinghours">График работы</h1>
                <p>Пн-Пт: 09:00 - 20:00</p>
                <p>Сб-Вс: 11:00 - 16:00</p>
                <h1 id="contacts">Наши контакты</h1>
                <p>+7 (495) 555-58-16</p>
                <p>+7 (495) 752-37-78</p>
                <p>+7 (495) 799-47-76</p>
            </div>
        </div>
    </div>
</div>
<footer>

</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!--Скрипт на подключение к библиотеке JQuery-->
<script src=" /scripts/mixitup.min.js "></script>
<script src=" /scripts/mixitup-multifilter.min.js"></script>
<script src="/scripts/index.js"></script> <!--Подключение основного JS файла к документу-->
</body>
</html>




	