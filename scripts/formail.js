// $(document).ready(function () {
//     loadCart();
//     createTable();
// });
//
// function loadCart() { // загрузка корзины
//     //проверяю есть ли в localStorage запись cart
//     if (localStorage.getItem('cart')) {
//         // если есть - расширфровываю и записываю в переменную cart
//         cart = JSON.parse(localStorage.getItem('cart'));
//     }
// }
// function createTable() { // таблица сформированного заказа
//     let out = '';
//     const good = localStorage.cart.good;
//     for (let i = 0; i < cart.length; i++) {
//         out += `<tr>`;
//         for (let key of Object.values(cart[i].good)) {
//             out += `<td>` + key + `</td><br>`
//         }
//         out += `</tr>`
//     }
//     $('.formsend').html(out)
// }
$(document).on('click', '#submit-btn', function() {
    let cart = JSON.parse(localStorage.cart);
    let out = '';
    for (var i = 0; i < cart.length; i++) {
        out += i;
    }
    $.ajax({
        url: '../form-lesson/mail.php',
        type: 'POST',
        data: out,
        success: function (data) {
            console.log('NOT ERROR');
        },
        error: function () {
            console.log('ERROR');
        }
    })
})



