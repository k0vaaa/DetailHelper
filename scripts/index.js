$(document).ready(function () {
    $('.add-to-cart').on('click', addToCart);
    $('.sortimgs').on('click', function (e) {
        changeSortLabel(e.target.id);
    });
    $('#headercarttrigger').on('click', openHeaderCart);
    if (!localStorage.getItem('cart')) { /*условие проверки наличия объекта "cart" в локальнеом хранилище браузера*/
        let cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
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

    function scrollToAnchor() {
        const destination = $('#secondblock');
        $('html').animate({
            scrollTop: (destination.offset().top - 90)
        }, 'slow');
    }

    $('#tocatalog').on('click', function () {
        scrollToAnchor();
    });
    select();
    backToTop();
    hideHeaderCart();
});

function backToTop() { /*Функция показа кнопки "наверх" при скролле*/
    let btn = $('.back-to-top');

    $(document).on('scroll', () => {
        if ($(document).scrollTop() > 500) {
            $('.back-to-top').addClass('visible');
        } else {
            $('.back-to-top').removeClass('visible');
        }
    });

    btn.on('click', (e) => {
        e.preventDefault();
        $('html').animate({scrollTop: 0}, {duration: 800});
    })
}

$(document).scroll(function () { // функция закрепления шапки при скролле
    if ($(document).scrollTop() > $('header').height() - 70)
        $('header').addClass('fixed');
    else
        $('header').removeClass('fixed');
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

    hideHeaderCart();
    totalSum();
};

// function loadCart() { // загрузка корзины
// 	//проверяю есть ли в localStorage запись cart
// 	if (localStorage.getItem('cart')) {
// 		// если есть - расширфровываю и записываю в переменную cart
// 		cart = JSON.parse(localStorage.getItem('cart'));
// 	}
// };


function openHeaderCart() {
    if (document.querySelector(".headercart__body").style.display == 'block') {
        document.querySelector(".headercart__body").style.display = 'none';
    } else {
        document.querySelector(".headercart__body").style.display = 'block';
    }
    hideHeaderCart();
}

let select = function () {
    let selectHeader = document.querySelectorAll('.select__header');
    let selectItem = document.querySelectorAll('.select__item');

    let icon = document.getElementById('icon');
    document.querySelector('.select__header').onclick = function () {
        icon.classList.toggle('rotateicon');
    }
    selectHeader.forEach(item => {
        item.addEventListener('click', selectToggle);
    });
    selectItem.forEach(item => {
        item.addEventListener('click', selectChoose);
    });
    // icon.forEach(item=>{
    // 	item.addEventListener('click', changeIcon);
    // });
    function selectToggle() {
        this.parentElement.classList.toggle('is-active');
    }

    function selectChoose() {
        let text = this.innerText,
            select = this.closest('.select'),
            currentText = this.closest('.select').querySelector('.select__current');
        currentText.innerText = text;
        select.classList.remove('is-active');
        document.querySelector('.select__header').onclick = function () {
            icon.classList.toggle('rotateicon');
        }
    }
}

function changeSortLabel(s) {
    // document.querySelector("#changesorttitle").textContent = "Сортировка цены по возрастанию";
    switch (s) {
        case 'pricelowtohigh':
            document.querySelector("#changesorttitle").textContent = "Сортировка цены по возрастанию";
            // document.querySelector("#pricelowtohigh").outerHTML = '<img src="content/pricehightolow.png" id="pricehightolow" data-sort="price:desc">';
            document.querySelectorAll('.sortimgs > img').forEach(item => {
                item.style.backgroundColor = '#ffff';
            })
            document.querySelector("#pricelowtohigh").style.backgroundColor = '#4b4b4b';
            break;

        case 'pricehightolow':
            document.querySelector("#changesorttitle").textContent = "Сортировка цены по убыванию";
            // document.querySelector("#pricehightolow").outerHTML = '<img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">';
            document.querySelectorAll('.sortimgs > img').forEach(item => {
                item.style.backgroundColor = '#ffff';
            })
            document.querySelector("#pricehightolow").style.backgroundColor = '#4b4b4b';
            break;

        case 'nameatoz':
            document.querySelector("#changesorttitle").textContent = "Сортировка наименования от A до Z";
            // document.querySelector("#nameatoz").outerHTML = '<img src="content/nameztoa.png" id="nameztoa" data-sort="name:desc">';
            document.querySelectorAll('.sortimgs > img').forEach(item => {
                item.style.backgroundColor = '#ffff';
            })
            document.querySelector("#nameatoz").style.backgroundColor = '#4b4b4b';
            break;

        case 'nameztoa':
            document.querySelector("#changesorttitle").textContent = "Сортировка наименования от Z до A";
            // document.querySelector("#nameztoa").outerHTML = '<img src="content/nameatoz.png" id="nameatoz" data-sort="name:asc">';
            document.querySelectorAll('.sortimgs > img').forEach(item => {
                item.style.backgroundColor = '#ffff';
            })
            document.querySelector("#nameztoa").style.backgroundColor = '#4b4b4b';
            break;

        case 'random':
            document.querySelector("#changesorttitle").textContent = "Случайная сортировка";
            // document.querySelector("#nameztoa").outerHTML = '<img src="content/nameatoz.png" id="nameatoz" data-sort="name:asc">';
            document.querySelectorAll('.sortimgs > img').forEach(item => {
                item.style.backgroundColor = '#ffff';
            })
            document.querySelector("#random").style.backgroundColor = '#4b4b4b';
            break;
    }
}

function loadCart() { /*загрузка корзины при переходе в личный кабинет*/
    if (localStorage.getItem('cart')) { /*проверка на существование объекта в локальном хранилище */
        cart = JSON.parse(localStorage.getItem('cart')); /*расшифровка и запись в переменную*/
    }
};

function cartOutput() {

    document.querySelector(".headercart__body__content").style.display = 'block ';
    if (document.querySelector("#emptycartout")){
        document.querySelector("#emptycartout").style.display = 'none';
    }
    loadCart();
    let out = '';

    for (let i = 0; i < cart.length; i++) {
        out += '<tr>';
        for (let [key, value] of Object.entries(cart[i].good)) {
            if (key == 'name') {
                out += '<td><span class="table__name__brand__model">' + value + ' для';
            } else if (key == 'brand') {
                out += ' ' + value;
            } else if (key == 'model') {
                out += ' ' + value + `</span></td>`;
            } else if (key == 'price') {
                out += `<td class="tableprice"><span>`+value+`</span></td>`;
            } else if (key == 'count') {
                out += `<td class="tablecount"><button class="plus" data-id="${cart[i].id}" id="changequantity">+</button><span>` + value + `</span><button class="minus" data-id="${cart[i].id}" id="changequantity">-</button></td>`;
            }
        }
        out += `</tr>`;
    }
    $('.carttableout').html(out);
    totalSum();
    $('.minus').on('click', (event) => { /*функция, срабатывающая по нажатию на "увеличить количество" в окне-конструкторе*/
        const id = event.target.getAttribute('data-id');
        minusGoods(id); /*обращение к функции добавления единицы товара с передачей идентификатора*/
    });
    $('.plus').on('click', (event) => { /*функция, срабатывающая по нажатию на "увеличить количество" в окне-конструкторе*/
        const id = event.target.getAttribute('data-id');
        plusGoods(id); /*обращение к функции добавления единицы товара с передачей идентификатора*/
    });
}


function minusGoods(id) { /*функция уменьшения количества единиц товара с получением идентификатора*/
    let cart = JSON.parse(localStorage.cart);
    const targetIndex = cart.findIndex((item) => item.id === id);
    if (targetIndex !== -1) { /*условие на поиск соответствия с идентификатором*/
        if (cart[targetIndex].good.count > 1) { /*проверка на количество единиц товара (более одной для дальнейшего уменьшения)*/
            cart[targetIndex].good.count--;
        } else {
            cart.splice(targetIndex, 1);/*удаление идентификатора товара из локального
            хранилища при актуальном количестве в одну единицу*/
        }
        localStorage.cart = JSON.stringify(cart);/*перезагрузка корзины*/

    }
    hideHeaderCart();
};

function plusGoods(id) { /*функция увеличения количества единиц товара с получением идентификатора*/
    let cart= JSON.parse(localStorage.cart);
    const targetIndex = cart.findIndex((item) => item.id === id);
    if (targetIndex !== -1) { /*условие на поиск соответствия с идентификатором*/
        cart[targetIndex].good.count++; /*увеличение количества товара с указанным идентификатором на единицу*/
        localStorage.cart = JSON.stringify(cart);

    }
    hideHeaderCart();
};

function totalSum() {
    let cart = JSON.parse(localStorage.cart);
    let summa=0;
    for (let i=0; i<cart.length; i++) {
        summa+= cart[i].good.price*cart[i].good.count;
    }
    $('.summa').html(summa);
}

function hideHeaderCart(){
    loadCart();
    if (cart.length===0) {
        document.querySelector(".headercart__body__content").style.display = 'none';
        // document.querySelector(".headercart__body__content").style.minHeight = '600';
        let out='<p id="emptycartout">Корзина пуста, обратитесь к нашему <a href="">каталогу</a>!</p>';
        $('.emptyheadercart').html(out);
    }
    else{
        cartOutput();
        totalSum();
    }
}