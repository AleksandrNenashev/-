<?php
            $savedData = COption::GetOptionString("main", "featured_items");
            $featuredItems = unserialize($savedData);

            if (!empty($featuredItems)): ?>
            <div class="sales m-section">
                <div class="container _type2">
                    <div class="h2 text-center">
                        распродажа
                    </div>
                    <div class="sales-slider slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
							<?foreach ($featuredItems as $item)
			                   {
				                ?>
                                <div class="swiper-slide">
                                    <div class="product-card">

                                        <div class="product-card__badges">

                                        <!-- Значок "NEW" -->
                                        <?if($item['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'):?>
                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="Новинка">
                                            </div>
                                        <?endif;?>

                                       <!-- Значок скидки -->
                                        <?if($item['DISCOUNT_PERCENT'] > 0):?>
                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="Скидка">
                                            </div>
                                        <?endif;?>

                                        <!-- Значок экологичности -->
                                        <?if(!empty($item['PROPERTIES']['PR100']['VALUE'])):?>
                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="Эко">
                                            </div>
                                        <?endif;?>   
                                        </div>

										<a href="<?=$item['URL']?>" class="product-card__img"><img src="<?=$item['IMAGE']?>" alt="<?=$item['NAME']?>"></a>
                                        <div class="product-card__title"> 
                                            <a href="<?=$item['URL']?>" class="text21 text14-mob"><?=$item['NAME']?></a>
                                        </div>
                                        <div class="product-card__prices">
                                            <div class="product-card__price">
                                            <?=$item['PRICE']?> Р
                                            </div>
                                            <div class="product-card__price2">
                                            <?if($item['DISCOUNT_PERCENT'] > 0):?>
                                                <?=$item['OLD_PRICE']?> Р
                                            <?endif;?>
                                            </div>
                                            <a class="addtobasket btn btn_green" href="#" id="ajaxaction=add&ajaxaddid=<?=$item['ID']?>">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                                <?}?>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <?endif;?>
<script>
    $(document).ready(function () {
    $(".addtobasket").on("click", function (e) {
        e.preventDefault();

        var itemId = $(this).attr("id").split("&")[1].split("=")[1]; // Извлекаем ID товара

                $.ajax({
                    url: '/ajax/ajax.php',  // Путь к файлу
                    method: 'POST',
                    data: {
                        action: 'add',
                        product_id: itemId
                    },
                    success: function(response) {
                        if (response.success) {
                            updateCart(response.quantity, response.sum);
                        } else {
                            alert('Ошибка добавления товара в корзину');
                        }
                    },
                    error: function() {
                        alert('Ошибка выполнения запроса');
                    }
                });

    });

    // Функция для обновления мини-корзины
    function updateCart(quantity, sum) {
        $(".header__cart-in a").html("В корзине " + quantity + " товаров");
        $(".header__cart-drop .header__cart-btn .header__cart-price").html("Итого: " + sum + " Р");
        $(".header__cart-in").animate({
            left: "0",
        }, 1000);
    }
});
</script>