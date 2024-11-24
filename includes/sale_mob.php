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
												<a class="addtobasket btn btn_green" href="#" id="ajaxaction=add&amp;ajaxaddid=<?=$arItem['PRICES']['RUB']['ONE']?>">В корзину</a>
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