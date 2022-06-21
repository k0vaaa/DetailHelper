$(document).ready(function () {

    $('.add-to-cart').on('click', addToCart);
    $('.sortimgs').on('click', function (e) {
        changeSortLabel(e.target.className);
    });
    $('#tocatalog1').on('click', scrollToAnchor);
    $('#tocatalog2').on('click', scrollToAnchor2);
    $('#toinfo').on('click', scrollToAnchor3);
    $('#headercarttrigger').on('click', openHeaderCart);
    // $('.select__item').on('click',  function (e) {
    //     chooseAnotherFilter(e.target);
    // });
    // $('#searchbutton').on('click', sendToDb);

    $('#button1').on('click',sendLocalStorage);
    if (!localStorage.getItem('cart')) { /*условие проверки наличия объекта "cart" в локальнеом хранилище браузера*/
        let cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    $.ajax({
        url: 'vendor/filter.php',
        type: 'GET',
        success: function (data){
            let result = JSON.parse(data);
            let out=" ";
            for (let i = 0; i < result.length; i++){
                 out+= '<div class="select__item" data-filter=".m' + result[i].id_model + '">' + result[i].nameofmodel + '</div>'
            }
            out += '<div class="select__item" data-filter="">Все модели</div>'
            $('#modelfilter').html(out);
        },
        error: function (){
            console.log('Error')
        }
    })





    let mixer = mixitup('.cards', {
        multifilter: {
            enable: true
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
            scrollTop: (destination.offset().top + 15)
        }, 500);
    }

    function scrollToAnchor2() {
        const destination = $('#secondblock');
        $('html').animate({
            scrollTop: (destination.offset().top + 15)
        }, 500);
    }

    function scrollToAnchor3() {
        const destination = $('#thirdblock');
        $('html').animate({
            scrollTop: (destination.offset().top - 90)
        }, 800);
    }



    loadCart();
    select();
    backToTop();
    hideHeaderCart();

});

   // function checkFastOrder() {
   //     // let cart = JSON.parse(localStorage.getItem('cart'));
   //     // localStorage.cart = JSON.stringify(cart);
   //     let cart = JSON.parse(localStorage.cart);
   //     let maxcount= 0;
   //     for (let i = 0; i < cart.length; i++) {
   //         maxcount += cart[i].good.count;
   //     }
   //     if (maxcount > 3){
   //         document.querySelector("#button1").style.display = 'none';
   //     }
   //     else {
   //         document.querySelector("#button1").style.display = 'inline-block';
   //     }
   // }

function checkFastOrder() {
    // let cart = JSON.parse(localStorage.getItem('cart'));
    // localStorage.cart = JSON.stringify(cart);
    let cart = JSON.parse(localStorage.cart);
    let maxcount= 0;
    for (let i = 0; i < cart.length; i++) {
        maxcount += cart[i].good.count;
    }
    if (maxcount > 3){
        document.querySelector("#button1").style.display = 'none';
    }
    else {
        document.querySelector("#button1").style.display = 'inline-block';
    }
}



function backToTop() { /*Функция показа кнопки "наверх" при скролле*/
    let btn = $('.back-to-top');
    $(document).on('scroll', () => {
        if ($(document).scrollTop() > 500 ) {
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


// function windowScrollCheck() {
    // let hasScrolling = !(window.scrollY === 900);
    // if (hasScrolling == true) {
    //     $('.back-to-top').addClass('visible');
    //     console.log('прокрут более 1000')
    // }
    // else {
    //     $('.back-to-top').removeClass('visible');
    //     console.log('прокрут менее 1000')
    // }

    // window.onscroll = () => {
    //     const hasScrolling = !(window.scrollX === 0 && window.scrollY === 900);
    //     $('.back-to-top').addClass('visible');
    // }
    // $('.back-to-top').removeClass('visible');
    //
    // if (scrollX === 0 && scrollY === 0) {
    //     window.onscroll();
    // }

function addToCart() {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let a = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    let price = $(this).attr('data-price');
    let brand = $(this).attr('data-brand');
    let model = $(this).attr('data-model');
    let quantity=$(this).attr('data-quantity');
    localStorage.cart = JSON.stringify(cart);
    let cartNew = JSON.parse(localStorage.cart);
    const targetIndex = cartNew.findIndex((item) => item.id === a);
    if (targetIndex !== -1) {
        if (cartNew[targetIndex].good.count < quantity ) {
            cartNew[targetIndex].good.count++;
        }
        else {
            alert('В наличии нет такого количества выбранного товара. Максимальное количество для заказа: '+quantity+ ' шт.')
        }
    } else {
        cartNew.push({
            id: a,
            good: {
                name: name,
                brand: brand,
                model: model,
                price: price,
                count: 1
            },
            maxvalue: quantity
        });
    }
    localStorage.cart = JSON.stringify(cartNew);
    hideHeaderCart();
    totalSum();
    checkFastOrder();
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

    document.querySelector('#filterbrand').onclick = function () {
        document.querySelector('#filterbrand div.select__icon').classList.toggle('rotateicon');
        document.querySelector('#headerbrand').parentElement.classList.toggle('is-active');
        document.querySelectorAll('#filterbrand .select__item').forEach(item => {
            item.addEventListener('click',function (){
                let text = this.innerText,
                    select = this.closest('.select'),
                    currentText = this.closest('.select').querySelector('.select__current'),
                    icon = document.getElementById('icon');
                currentText.innerText = text;
                let data = currentText.innerText;
                document.querySelector('#headerbrand').parentElement.classList.remove('is-active');
                document.querySelector('#filterbrand div.select__icon').classList.remove('rotateicon');
                $.ajax({
                    url: 'vendor/filter.php',
                    type: 'POST',
                    data: {model: data},
                    success: function (data){
                        let result = JSON.parse(data);
                        let out=" ";
                        for (let i = 0; i < result.length; i++){
                            out+= '<div class="select__item" data-filter=".m' + result[i].id_model + '">' + result[i].nameofmodel + '</div>'
                        }
                        out += '<div class="select__item" data-filter="">Все модели</div>'
                        $('#modelfilter').html(out);
                    },
                    error: function (){
                        console.log('Error')
                    }
                })
            });
        });
    }
    document.querySelector('#filtermodel').onclick = function () {
        document.querySelector('#filtermodel div.select__icon').classList.toggle('rotateicon');
        document.querySelector('#headermodel ').parentElement.classList.toggle('is-active');
        document.querySelectorAll('#filtermodel .select__item').forEach(item => {
            item.addEventListener('click',function (){
                let text = this.innerText,
                    select = this.closest('.select'),
                    currentText = this.closest('.select').querySelector('.select__current'),
                    icon = document.getElementById('icon');
                currentText.innerText = text;
                document.querySelector('#headermodel ').parentElement.classList.remove('is-active');
                document.querySelector('#filtermodel div.select__icon').classList.remove('rotateicon');
            });
        });
    }
    document.querySelector('#filtercategory').onclick = function () {
        document.querySelector('#filtercategory div.select__icon').classList.toggle('rotateicon');
        document.querySelector('#headercategory').parentElement.classList.toggle('is-active');
        document.querySelectorAll('#filtercategory .select__item').forEach(item => {
            item.addEventListener('click',function (){
                let text = this.innerText,
                    select = this.closest('.select'),
                    currentText = this.closest('.select').querySelector('.select__current'),
                    icon = document.getElementById('icon');
                currentText.innerText = text;
                document.querySelector('#headercategory').parentElement.classList.remove('is-active');
                document.querySelector('#filtercategory div.select__icon').classList.remove('rotateicon');
            });
        });
    }
}

function changeSortLabel(s) {
    // document.querySelector("#changesorttitle").textContent = "Сортировка цены по возрастанию";
    switch (s) {
        case 'pricelowtohigh':
            document.querySelector("#changesorttitle").textContent = "Сортировка цены по возрастанию";
            // document.querySelector("#pricelowtohigh").outerHTML = '<img src="content/pricehightolow.png" id="pricehightolow" data-sort="price:desc">';
            document.querySelectorAll('.sortimgs > div').forEach(item => {
                if (item.getAttribute('id')=='selected'){
                    item.removeAttribute('id');
                }
            })
            document.querySelector(".pricelowtohighclass").setAttribute('id','selected');
            break;
        case 'pricehightolow':
            document.querySelector("#changesorttitle").textContent = "Сортировка цены по убыванию";
            // document.querySelector("#pricehightolow").outerHTML = '<img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">';
            document.querySelectorAll('.sortimgs > div').forEach(item => {
                if (item.getAttribute('id')=='selected'){
                    item.removeAttribute('id');
                }
            })
                document.querySelector(".pricehightolowclass").setAttribute('id','selected');
            break;
        case 'nameatoz':
            document.querySelector("#changesorttitle").textContent = "Сортировка наименования от A до Z";
            // document.querySelector("#pricehightolow").outerHTML = '<img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">';
            document.querySelectorAll('.sortimgs > div').forEach(item => {
                if (item.getAttribute('id')=='selected'){
                    item.removeAttribute('id');
                }
            })
            document.querySelector(".nameatozclass").setAttribute('id','selected');
            break;
        case 'nameztoa':
            document.querySelector("#changesorttitle").textContent = "Сортировка наименования от Z до A";
            // document.querySelector("#pricehightolow").outerHTML = '<img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">';
            document.querySelectorAll('.sortimgs > div').forEach(item => {
                if (item.getAttribute('id')=='selected'){
                    item.removeAttribute('id');
                }
            })
            document.querySelector(".nameztoaclass").setAttribute('id','selected');
            break;
        case 'random':
            document.querySelector("#changesorttitle").textContent = "Случайная сортировка";
            // document.querySelector("#pricehightolow").outerHTML = '<img src="content/pricelowtohigh.png" id="pricelowtohigh" data-sort="price:asc">';
            document.querySelectorAll('.sortimgs > div').forEach(item => {
                if (item.getAttribute('id')=='selected'){
                    item.removeAttribute('id');
                }
            })
            document.querySelector(".randomclass").setAttribute('id','selected');
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
    document.querySelector(".tablesum").style.display = 'block ';
    document.querySelector(".orderheaderbtns").style.display = 'block ';
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
    checkFastOrder();
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
        if (cart[targetIndex].good.count < cart[targetIndex].maxvalue) {
            cart[targetIndex].good.count++; /*увеличение количества товара с указанным идентификатором на единицу*/
        } else {
            alert('В наличии нет такого количества выбранного товара. Максимальное количество для заказа: ' + cart[targetIndex].maxvalue + ' шт.')
        }
    }
    localStorage.cart = JSON.stringify(cart);
    hideHeaderCart();
};


function hideHeaderCart(){
    loadCart();
    if (cart.length===0) {
        document.querySelector(".headercart__body__content").style.display = 'none';
        document.querySelector(".orderheaderbtns").style.display = 'none';
        document.querySelector(".tablesum").style.display = 'none';
        // document.querySelector(".headercart__body__content").style.minHeight = '600';
        let out='<p id="emptycartout">Корзина пуста, обратитесь к нашему каталогу</a>!</p>';
        $('.emptyheadercart').html(out);
    }
    else{
        cartOutput();

    }
}

function totalSum() {
    let cart = JSON.parse(localStorage.cart);
    let summa = 0;
    for (let i = 0; i < cart.length; i++) {
        summa += cart[i].good.price * cart[i].good.count;
    }
    $('.summa').html(summa);
    return summa;
}

function sendLocalStorage(){ /*функция отправки содержимого корзины, используемого при формировании email-письма*/
    let cart = JSON.stringify(localStorage.getItem('cart'));
    document.querySelector('[name=receivecart]').value = cart;
    document.querySelector('[name=totalsumm]').value = totalSum();
}



const headers = document.querySelectorAll("[data-name='spoiler-title']");
headers.forEach(function(item) {
    item.addEventListener("click", headerClick);
});
function headerClick() {
    this.nextElementSibling.classList.toggle("spoiler-body");
}