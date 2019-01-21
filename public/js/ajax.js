// JavaScript Document

function register(){
	var login = encodeURI(document.getElementById('login').value);
	var password = encodeURI(document.getElementById('pass').value);
	var rememberme = encodeURI(document.getElementById('rememberme').checked);
	var rememberme2 = encodeURI(document.getElementById('rememberme').checked);
          $.ajax({ type: 'POST',
              url: '/index.php',
              data: { metod: 'ajax',
                  PageAjax: 'register',
                  var3: rememberme2,
                  login: login,
                  pass: password,
                  rememberme: rememberme},
              success: function(response){
                    $('#autorize').html(response);
                 },
				 dataType:"json"
          });
	};


 
// function add_basket(var3) {
//  var var4 = $(var3).attr("data-product-guid");
//  var count = encodeURI(document.getElementById('i2').value);
//           $.ajax({ type: 'POST', url: 'index.php', data: { metod: 'ajax', PageAjax: 'basket', var4: var4, count: count}, success: function(response){
//                     $('#basket').html(response);
//                  },
// 				 dataType:"json"
//           });
//    }

// функция, отправляющая Ajax-запрос при нажатии на кнопку "Добавить"/"Купить" в корзине/каталоге/карточке товара
 function add_basket_one(var3) { 
 // var var4 = $(var3).attr("data-product-guid"); // uid товара
          $.ajax({
              type: 'POST',
              url: '/index.php',
              data: {
                  metod: 'ajax',
                  PageAjax: 'basket', // будет вызван метод Ajax::basket();
                  // var4: var4
                  var4: var3

              }, success: function(response){
                  $('#' + var3).children('.product_in_cart__quantity').html(response);
                 },
				 dataType:"json"
          });
          alert("Товар добавлен в корзину!");
   }

// функция, отправляющая Ajax-запрос при нажатии на кнопку "Уменьшить" в корзине
function reduce_basket_one(var3) {
       $.ajax({
           type: 'POST',
           url: '/index.php',
           data: {
               metod: 'ajax',
               PageAjax: 'basketReduce', // будет вызван метод Ajax::basket();
               var4: var3

           }, success: function(response){
               if (response === '') {
                   $('#' + var3).html(response);
               } else {
                   $('#' + var3).children('.product_in_cart__quantity').html(response);
               }
           },
           dataType:"json"
       });
       // alert("Товар добавлен в корзину!");
   }

// функция, отправляющая Ajax-запрос при нажатии на кнопку "Удалить" в корзине
function delete_basket_one(var3) {
       $.ajax({
           type: 'POST',
           // url: 'index.php',
           url: '/index.php',
           data: {
               metod: 'ajax',
               PageAjax: 'basketDelete', // будет вызван метод Ajax::basket();
               // var4: var4
               var4: var3

           }, success: function(response){
               $('#' + var3).html(response);
           },
           dataType:"json"
       });
       // alert("Товар удален!");
   }

function clear_basket() { 
          $.ajax({ type: 'POST', url: 'index.php', data: { metod: 'ajax', PageAjax: 'clear_basket'}, success: function(response){
                    $('#basket').html(response);
                 },
				 dataType:"json"
          });
   }

// функция, отправляющая Ajax-запрос при нажатии на кнопку "Разместить заказ" в корзине
function place_order() {
       $.ajax({
           type: 'POST',
           // url: 'index.php',
           url: '/index.php',
           data: {
               metod: 'ajax',
               PageAjax: 'placeOrder', // будет вызван метод Ajax::basket();

           }, success: function(response){
               $('.cart').html(response);
           },
           dataType:"json"
       });
   }

// функция, отправляющая Ajax-запрос для получения списка товаров в заказе при нажатии на номер заказа в ЛК
function get_order(id) {
       $.ajax({
           type: 'POST',
           // url: 'index.php',
           url: '/index.php',
           data: {
               metod: 'ajax',
               PageAjax: 'getOrder',
               id: id

           }, success: function(response){
               $('#' + id).children('.order_contents').html(response);
           },
           dataType:"json"
       });
   }

// Функция, отправляющая Ajax-запрос при нажатии на кнопку "Показать еще" в каталоге
 function see_additional_goods(var3) { 
 var count = $(var3).attr("count_tovar");
 var category = $(var3).attr("category");
 var current_record = $(var3).attr("current_record");
          $.ajax({
              type: 'POST',
              url: '/index.php',
              data: {
                  metod: 'ajax',
                  PageAjax: 'see_additional_goods',
                  count: count,
                  category: category,
                  current_record: current_record
              }, success: function(response){
                  console.log(response);
                    $('#button_see_additional_goods').after(response);
					$('#button_see_additional_goods').remove();
                 },
				 dataType:"json"
          });
   } 

   // фукнция, отправляющая Ajax-запрос при смене статуса заказа
   function changeStatus(id) {
       // var newStatus = $('#' + id).children('select').value;
       var newStatus = $('.select-' + id).val();
       // console.log('Changed: ' + id);
       $.ajax({
           type: 'POST',
           url: '/index.php',
           data: {
               metod: 'ajax',
               PageAjax: 'changeStatus',
               id: id,
               statusName: newStatus,
           }, success: function(response){
               console.log(response);
               $('#' + id).children('.order_status').html(newStatus);
           },
           dataType:"json"
       });
   }


