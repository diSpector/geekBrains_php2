{% for item in content_data %}
<div class="order__product">
<!--    <div class="order__product_name">{{item.good_uid}}</div>-->
    <div class="order__product_name"><a href="/good/{{item.id_good}}/">{{item.name}}</a></div>
    <div class="order__product_quantity">{{item.quantity}}</div>

</div>

{% endfor %}