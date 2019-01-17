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
        <p>Вы недавно смотрели:</p>
        {% for item in content_data%}
            <p><a href = "{{domain}}{{item.url}}/">{{item.url}}</a></p>
        {%endfor%}
<!--		{% include 'new-product.html' %}-->

    </div>

    <!-- Нижняя часть главного блока -->
	{% include 'brand.html' %}

	{% include 'instagram.html' %}

     {% include 'network.html' %}

    </div>

		{% include 'footer.html' %}
</body>

</html>