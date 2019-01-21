{% include 'header.html' %}

<!-- Основной блок -->
    <div class="main">

    <!-- Левый блок -->
    <div class="left">

        <!-- Меню -->
	{% include 'menu.html' %}

        <div class="open">
            <p>now<br>is<br>open!</p>
        </div>

    </div>

    <!-- Правый блок -->
    <div class="right">
{% include 'bread_crumbs.html' %}

<!-- ВЫВОД КОРЗИНЫ-->
        {{title}}
        <div class="cart">
            <div class = "product_in_cart">
                <div class = "product_in_cart__name">Название</div>
                <div class = "product_in_cart__price">Цена</div>
                <div class = "product_in_cart__quantity">Количество</div>
            </div>
            {% for item in content_data %}
<!--            <div class = "product_in_cart" id = "#{{item.uid_good}}">-->
            <div class = "product_in_cart" id = "{{item.uid_good}}">

                <div class = "product_in_cart__name"><a href="{{domain}}good/{{item.id_good}}/">{{item.name}}</a></div>
                <div class = "product_in_cart__price">{{item.price}}</div>
                <div class = "product_in_cart__quantity">{{item.quantity}}</div>

                <div class="product_in_cart__btn_add">
<!--                    <a href="javascript:add_basket_one('#{{ item.uid_good }}')" id="{{ item.uid_good }}" data-product-guid="{{ item.uid_good }}">-->
                        <a href="javascript:add_basket_one('{{ item.uid_good }}')" id="{{ item.uid_good }}" data-product-guid="{{ item.uid_good }}">
                        Добавить
                    </a>
                </div>
                <div class="product_in_cart__btn_reduce">
                    <a href="javascript:reduce_basket_one('{{ item.uid_good }}')" id="{{ item.uid_good }}" data-product-guid="{{ item.uid_good }}">
                        Уменьшить
                    </a></div>

                <div class="product_in_cart__btn_remove">
                    <a href="javascript:delete_basket_one('{{ item.uid_good }}')" id="{{ item.uid_good }}" data-product-guid="{{ item.uid_good }}">
                    Удалить
                    </a>
                </div>
            </div>
            {% endfor %}
            <div class="cart__btn_place_order">
                <a href="javascript:place_order()">
                    Оформить заказ
                </a>
            </div>

        </div>
</div>
    </div>


    <!-- Нижняя часть главного блока -->
	{% include 'brand.html' %}

	{% include 'instagram.html' %}

     {% include 'network.html' %}
    </div>



    </div>
	{% include 'footer.html' %}
</body>

</html>