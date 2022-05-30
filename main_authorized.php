<?php 
	session_start();
	require_once 'vendor/connect.php';
	if (!$_SESSION['user']) {
		header('Location: authorization.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>BrandName</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/styles/main.css">



</head>
<body>	
	<div class="back-to-top">
		<img src="content/arrow.png">
	</div>
		<header class="header">
			<div class="header_section">
				<div class="header_item logo">
                    Detail Helper
				</div>
				
			</div>
			<div class="header_section">
				<div class="header_item">
					<a href="#catalog">Каталог</a>
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
				<div class="header_item button">
					<a>Корзина</a>
				</div>
			</div>
		</header>
    <?php

    $result = mysqli_query($connect,"SELECT id_product,name,price,articul,brand,model,articul, quantity, description, pathtoimg FROM product");
    $products = array();

    while ($productInfo = $result->fetch_assoc()) {
        $products[] = $productInfo;
    }
    ?>
    <div id="firstblock" class="block"></div>
    <div id="secondblock" class="block">
        <h1>Каталог товаров</h1>
        <div class="catalog">
            <div class="filter">
                <h1>Фильтры</h1>
                <div class="filters">
                    <p>Фильтрация товаров по бренду:</p>
                    <button type="button" data-filter=".category-BMW">BMW</button>
                    <button type="button" data-filter=".category-Mercedes">Mercedes</button>
                    <button type="button" data-filter=".category-Volkswagen">Volkswagen</button>
                    <button type="button" data-filter="all">Всё</button>
                </div>
                <div class="filters">
                    <p>Сортировка товаров:</p>
                    <button type="button" data-sort="price:asc">Сортировка по цене (по возрастанию)</button>
                    <button type="button" data-sort="price:desc">Сортировка по цене (по убыванию)</button>
                    <button type="button" data-sort="name:asc">Сортировка по бренду (A->Z)</button>
                </div>
            </div>


            <div class="goods">
                <div class="cards">
                    <?foreach ($products as $product):?>
                        <div class="card mix category-<?=$product['brand']?>"  method="post" data-price="<?=$product['price']?>" data-name="<?=$product['brand']?>">
                            <img src="/content/<?=$product['pathtoimg']?>"></img>
                            <p id="name"><?=$product['name']?></p>
                            <p id="brandmodel"><?=$product['brand']?> <?=$product['model']?></p>
                            <p id="price"><?=$product['price']?>.<sup>00</sup> &#8381 </p>
                            <p id="quantity">В наличии: <?=$product['quantity']?> шт.</p>

<!--                        <a href="vendor/order.php?id=--><?//=$product['id_product']?><!--">Заказать</a>-->
                            <button type="submit" class="add-to-cart" data-id="<?=$product['id_product']?>"
                                    data-name="<?=$product['name']?>" data-price="<?=$product['price']?>">Заказать</button>
                            <p><a id="more" href="#popup_more<?=$product['id_product']?>" data-name="<?=$product['name']?>">подробнее</a></p>
                            <div id="popup_more<?=$product['id_product']?>" class="popup">
                                <a href="#header" class="popup__area"></a>
                                <div class="popup__body">
                                    <div class="popup__content">
                                        <div class="popup__title" id="card__title"><?=$product['name']?></div>
                                        <div class="popup__fill">
                                            <div class="columns">
                                            <img src="/content/<?=$product['pathtoimg']?>"></img>
                                                <div class="specs">
                                                    <p><b>Марка: </b><?=$product['brand']?></p>
                                                    <p><b>Модель: </b><?=$product['model']?></p>
                                                    <p><b>Артикул: </b><?=$product['articul']?></p>
                                                    <p><b>Наличие: </b>
                                                        <? if ($product['quantity']>0){
                                                            ?> <style> #aval {
                                                                color: #17a500;
                                                                font-weight: 400;
                                                                text-align: left;
                                                                margin: 0;
                                                                font-size: 1em;
                                                            }</style> <span id="aval"><?=$product['quantity']?> шт.</span>
                                                            <?
                                                        }
                                                        else {
                                                            ?> <style> #notaval {
                                                                    color: #900808;
                                                                    font-weight: 400;
                                                                    text-align: left;
                                                                    margin: 0;
                                                                    font-size: 1em;
                                                                }</style> <span id="notaval">нет</span>
                                                            <?
                                                       }
                                                        ?>
                                                    </p>
                                                    <br>
                                                    <p id="money"><b>Цена: </b><?=$product['price']?>.<sup>00</sup> &#8381 <? if ($product['quantity']>0){?>
                                                        <button id="notmail" type="submit" class="add-to-cart" href="vendor/order.php" data-id="<?=$product['id_product']?>"
                                                                data-name="<?=$product['name']?>" data-price="<?=$product['price']?>">Заказать</button><?
                                                    }
                                                    else {?> <style> #mail{
                                                            margin-left: 10px;
                                                            width:225px;
                                                            height: 45px;
                                                            font-size: 0.6em;
                                                            font-weight: 400;
                                                                } </style>
                                                    <button id="mail" type="submit" href="vendor/order.php" data-id="<?=$product['id_product']?>" data-name="<?=$product['name']?>">Сообщить о поступлении</button><?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <p id="descr"><?=$product['description']?></p>
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
<!--    <div class="block">-->
<!--        Наши склады-->
<!--    </div>-->
<!--    <footer>какая-то инфа</footer>-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script  src=" /scripts/mixitup.min.js "></script>
    <script src="/scripts/index.js"></script>
</body>
</html>
	