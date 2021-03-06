$(document).ready(function () {
    $('.dell-all').on('click',deleteAll); /*Привязка функций к клику на HTML элемент*/
    $('.basket').on('click', changeCart);
    $('#one').on('click',sendLocalStorage);
    if (!localStorage.getItem('cart')) { /*условие проверки наличия объекта "cart" в локальнеом хранилище браузера*/
        let cart = [];
        localStorage.setItem('cart',JSON.stringify(cart));
    }
    loadCart(); /*инициализация стартовых функций (загрузка корзины, проверка корзины на длину,  создание таблицы корзины)*/
    cartCheck();
});
function createTable() { /*функция создания таблицы с заказом*/
    let out = '';
    const good = localStorage.cart.good;
    for (let i=0; i<cart.length; i++) { /*цикл на вставку строк в таблицу с переменными*/
        out += `<tr>`;
        for (let [key,value] of Object.entries(cart[i].good)  ) {
            if (key=='price'){
                out+= `<td>`+ value+`.<sup>00</sup> &#8381 </td><br>`
            }
            else{
                out+= `<td>`+ value+`</td><br>`
            }
        }
        out+= `</tr>`
    }
    $('.elements').html(out); /*вывод содержимого таблицы в определенный HTML-класс*/
}


function changeCart() { /*функция формирования содержимого окна "Изменение заказа"*/
    let out = '';
    const good = localStorage.cart.good;
    for (let i=0; i<cart.length; i++) { /*цикл на вставку строки-макета*/
        out += `<tr id="basketrow">`;
        out+= `<td>` + cart[i].good.name + ` для ` +cart[i].good.brand + ` ` + cart[i].good.model + `<td>`
            + `<button class ="del-goods" data-id="${cart[i].id}">x</button>` + `<button class ="minus-goods" data-id="${cart[i].id}">-</button>`
            + cart[i].good.count + ` шт.`+ `<button class ="plus-goods" data-id="${cart[i].id}">+</button></td></td>`;
    }
    $('.basket').html(out); /*вывод содержимого окна в определенный HTML-класс*/

    $('.del-goods').on('click', (event) => { /*функция, срабатывающая по нажатию на "удалить товар" в окне-конструкторе*/
        const id = event.target.getAttribute('data-id');
        delGoods(id); /*обращение к функции  удаления единицы товара с передачей уникального идентификатора*/
    });
    $('.plus-goods').on('click', (event) => { /*функция, срабатывающая по нажатию на "увеличить количество" в окне-конструкторе*/
        const id = event.target.getAttribute('data-id');
        plusGoods(id); /*обращение к функции добавления единицы товара с передачей идентификатора*/
    });
    $('.minus-goods').on('click', (event) => { /*функция, срабатывающая по нажатию на "уменьшить количество" в окне-конструкторе*/
        const id = event.target.getAttribute('data-id');
        minusGoods(id); /*обращение к функции уменьшения единицы товара с передачей идентификатора*/
    });
    loadCart(); /*функция перезагрузки корзины*/
    if (cart.length===0){ /*условие, в котором при удалении всех товаров из заказа закроется окно-конструктор*/
        location.replace("/profile.php");
    }
};



function delGoods(id) { /*функция удаление единицы товара с получением идентификатора*/
    const good = JSON.parse(localStorage.cart);
    const targetIndex = cart.findIndex((item) => item.id === id);
    if (targetIndex !== -1) { /*условие на поиск соответствия с идентификатором*/
        good.splice(targetIndex, 1); /*удаление идентификатора товара из локального хранилища*/
        localStorage.cart = JSON.stringify(good);
        loadCart(); /*перезагрузка корзины*/
    }
}
function plusGoods(id) { /*функция увеличения количества единиц товара с получением идентификатора*/
    let cart= JSON.parse(localStorage.cart);
    const targetIndex = cart.findIndex((item) => item.id === id);
    if (targetIndex !== -1) { /*условие на поиск соответствия с идентификатором*/
        if (cart[targetIndex].good.count < cart[targetIndex].maxvalue ) {
            cart[targetIndex].good.count++;
        }
        else {
            alert('В наличии нет такого количества выбранного товара. Максимальное количество для заказа:'+cart[targetIndex].maxvalue)
        }
        localStorage.cart = JSON.stringify(cart);
        loadCart(); /*перезагрузка корзины*/
    }
};
function minusGoods(id) { /*функция уменьшения количества единиц товара с получением идентификатора*/
    let cart= JSON.parse(localStorage.cart);
    const targetIndex = cart.findIndex((item) => item.id === id);
    if (targetIndex !== -1) { /*условие на поиск соответствия с идентификатором*/
        if (cart[targetIndex].good.count>1){ /*проверка на количество единиц товара (более одной для дальнейшего уменьшения)*/
            cart[targetIndex].good.count--;
        }
        else {
            cart.splice(targetIndex, 1);/*удаление идентификатора товара из локального
            хранилища при актуальном количестве в одну единицу*/
        }
        localStorage.cart = JSON.stringify(cart);
        loadCart(); /*перезагрузка корзины*/
    }
};
function deleteAll() { /*функция, срабатывающая при нажатии кнопки "Удалить заказ"*/
    localStorage.clear(); /*очистка локального хранилища*/
    location.replace("/profile.php");
}
function cartCheck() { /*проверка корзины на пустоту для измененного вывода корзины*/
    if (cart.length===0) { /*пустая корзина - выводим надпись*/
        $('#emptycart').addClass ('yes');
        // document.querySelector('.emptycart').style.display = 'block';
    }
    else { /*коризна не пуста - выводим таблицу с содержимым корзины*/
        $('.zakaz').removeClass ('no'); /*скрытие элементов согласно условию*/
        // document.querySelector('.zakaz').style.display = 'block';
        $('#emptycart').addClass ('no');
        // document.querySelector('#emptycart').style.display = 'none';
        $('.ordermenu').removeClass ('no');
        // document.querySelector('.ordermenu').style.display = 'block';
        createTable(); /*вывод таблицы*/
        changeCart(); /*формирование содержимого окна "изменить заказ"*/
    }
}
function loadCart() { /*загрузка корзины при переходе в личный кабинет*/
    if (localStorage.getItem('cart')) { /*проверка на существование объекта в локальном хранилище */
        cart = JSON.parse(localStorage.getItem('cart')); /*расшифровка и запись в переменную*/
    }
    createTable(); /*функция пересоздает таблицу для динамического обновления*/
};

function totalSum() {
    let cart = JSON.parse(localStorage.cart);
    let summa=0;
    for (let i=0; i<cart.length; i++) {
        summa+= cart[i].good.price*cart[i].good.count;
    }
    return summa;
}

function sendLocalStorage(){ /*функция отправки содержимого корзины, используемого при формировании email-письма*/
    let cart = JSON.stringify(localStorage.getItem('cart'));
    document.querySelector('[name=receivecart]').value = cart;
    console.log(cart);
    document.querySelector('[name=totalsumm]').value = totalSum();
}


