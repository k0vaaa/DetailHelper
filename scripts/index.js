$(document).ready(function () {
	$('.add-to-cart').on('click', addToCart);
	$('.sortimgs').on('click', function (e){
		changeSortLabel(e.target.id);
	});
	$('#headercarttrigger').on('click',openHeaderCart);
	if (!localStorage.getItem('cart')) { /*условие проверки наличия объекта "cart" в локальнеом хранилище браузера*/
		let cart = [];
		localStorage.setItem('cart',JSON.stringify(cart));
	}

	let mixer = mixitup('.cards', {
		selectors: {
			target: '.card'
		},
		animation: {
			"duration": 0,
			"nudge": false,
			"reverseOut": false,
			"effects": "fade translateZ(-100px)"
		}
	});

	function scrollToAnchor(){
		const destination = $('#secondblock');
		$('html').animate({
			scrollTop: (destination.offset().top - 90)
		},'slow');
	}

	$('#tocatalog').on('click', function(){
		scrollToAnchor();
	});
	select();
	backToTop();
});

function backToTop() { /*Функция показа кнопки "наверх" при скролле*/
	let btn = $('.back-to-top');

	$(document).on('scroll',() => {
		if ($(document).scrollTop () > 500) {
			$('.back-to-top').addClass ('visible');
		} else {
			$('.back-to-top').removeClass ('visible');
		}
	});

	btn.on('click', (e) => {
		e.preventDefault();
		$('html').animate({scrollTop: 0}, {duration: 800});
	})
}

$(document).scroll (function () { // функция закрепления шапки при скролле
					if ($(document).scrollTop () > $('header').height () - 70)
						$('header').addClass ('fixed');
					else
						$('header').removeClass ('fixed');
					});

function addToCart() {

	let cart = JSON.parse(localStorage.getItem('cart'));
	let a = $(this).attr('data-id');
	let name = $(this).attr('data-name');
	let price = $(this).attr('data-price');
	let brand = $(this).attr('data-brand');
	let model = $(this).attr('data-model');

	localStorage.cart = JSON.stringify(cart);
	let cartNew = JSON.parse(localStorage.cart);

	const targetIndex = cartNew.findIndex((item) => item.id === a);
	if (targetIndex !== -1) {
		cartNew[targetIndex].good.count++;
	} else {
		cartNew.push({
			id: a,
			good: {
				name: name,
				brand: brand,
				model: model,
				price: price,
				count: 1
			}
		});
	}
	localStorage.cart = JSON.stringify(cartNew);
	cartOutput();
};

// function loadCart() { // загрузка корзины
// 	//проверяю есть ли в localStorage запись cart
// 	if (localStorage.getItem('cart')) {
// 		// если есть - расширфровываю и записываю в переменную cart
// 		cart = JSON.parse(localStorage.getItem('cart'));
// 	}
// };



function openHeaderCart(){
	if (document.querySelector(".headercart__body").style.display=='block'){
		document.querySelector(".headercart__body").style.display='none';
	}
	else {
		document.querySelector(".headercart__body").style.display='block';
	}
	cartOutput();
}

let select = function () {
	let selectHeader = document.querySelectorAll('.select__header');
	let selectItem = document.querySelectorAll('.select__item');


	let icon = document.getElementById('icon');
	document.querySelector('.select__header').onclick = function(){
		icon.classList.toggle('rotateicon');
	}

	selectHeader.forEach(item=>{
		item.addEventListener('click', selectToggle);
	});
	selectItem.forEach(item=>{
		item.addEventListener('click', selectChoose);
	});
	// icon.forEach(item=>{
	// 	item.addEventListener('click', changeIcon);
	// });
	function selectToggle(){
		this.parentElement.classList.toggle('is-active');
	}

	function selectChoose(){
		let text=this.innerText,
		 select = this.closest('.select'),
		currentText = this.closest('.select').querySelector('.select__current');
		currentText.innerText = text;
		select.classList.remove('is-active');
		document.querySelector('.select__header').onclick = function(){
			icon.classList.toggle('rotateicon');
		}
	}
}

function changeSortLabel(s){
		// document.querySelector("#changesorttitle").textContent = "Сортировка цены по возрастанию";
		switch(s){
			case 'pricelowtohigh':
				document.querySelector("#changesorttitle").textContent = "Сортировка цены по возрастанию";
				// document.querySelector("#pricelowtohigh").outerHTML = '<img src="content/pricehightolow.png" id="pricehightolow" data-sort="price:desc">';
				document.querySelectorAll('.sortimgs > img').forEach(item=>{
					item.style.backgroundColor='#ffff';
				})
				document.querySelector("#pricelowtohigh").style.backgroundColor='#4b4b4b';
				break;

			case 'pricehightolow':

				document.querySelector("#changesorttitle").textContent = "Сортировка цены по убыванию";
				// document.querySelector("#pricehightolow").outerHTML = '<img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">';
				document.querySelectorAll('.sortimgs > img').forEach(item=>{
					item.style.backgroundColor='#ffff';
				})
				document.querySelector("#pricehightolow").style.backgroundColor='#4b4b4b';
				break;

			case 'nameatoz':
				document.querySelector("#changesorttitle").textContent = "Сортировка наименования от A до Z";
				// document.querySelector("#nameatoz").outerHTML = '<img src="content/nameztoa.png" id="nameztoa" data-sort="name:desc">';

				document.querySelectorAll('.sortimgs > img').forEach(item=>{
					item.style.backgroundColor='#ffff';
				})
				document.querySelector("#nameatoz").style.backgroundColor='#4b4b4b';
				break;

			case 'nameztoa':
				document.querySelector("#changesorttitle").textContent = "Сортировка наименования от Z до A";
				// document.querySelector("#nameztoa").outerHTML = '<img src="content/nameatoz.png" id="nameatoz" data-sort="name:asc">';
				document.querySelectorAll('.sortimgs > img').forEach(item=>{
					item.style.backgroundColor='#ffff';
				})
				document.querySelector("#nameztoa").style.backgroundColor='#4b4b4b';
				break;

			case 'random':
				document.querySelector("#changesorttitle").textContent = "Случайная сортировка";
				// document.querySelector("#nameztoa").outerHTML = '<img src="content/nameatoz.png" id="nameatoz" data-sort="name:asc">';
				document.querySelectorAll('.sortimgs > img').forEach(item=>{
					item.style.backgroundColor='#ffff';
				})
				document.querySelector("#random").style.backgroundColor='#4b4b4b';
				break;
		}
	}

function loadCart() { /*загрузка корзины при переходе в личный кабинет*/
	if (localStorage.getItem('cart')) { /*проверка на существование объекта в локальном хранилище */
		cart = JSON.parse(localStorage.getItem('cart')); /*расшифровка и запись в переменную*/
	}
};


function cartOutput(){
	loadCart();
	let out = '';
	const good = localStorage.cart.good;
	for (let i=0; i<cart.length; i++) { /*цикл на вставку строк в таблицу с переменными*/
		out +=`<tr>`;
		for (let key of Object.values(cart[i].good)  ) {
			out+= `<td>`+ key+`</td><br>`
		}
		out+= `</tr>`
	}
		$('.carttableout').html(out);
	}