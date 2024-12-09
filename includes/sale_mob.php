<?php
            $savedData = COption::GetOptionString("main", "featured_items");
            $featuredItems = unserialize($savedData);
?>
<style>
.product-card__title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    -webkit-line-clamp: 3; 
    max-height: 120px;
    min-height: 60px;
    text-overflow: ellipsis;
}
</style>
<?
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
                                    <?if($item['PROPERTIES']['PRICE_LOWER']['VALUE'] == 'да'){?>
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/req.png" alt="Возможно изготовление по вашим размерам." class="product-card__request">  
                                        <?}?>
                                        <div class="product-card__badges">

                                        <!-- Значок "NEW" -->
                                        <?php if ($item['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'): ?>
                                                <div class="product-card__badge">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="Новинка">
                                                </div>
                                        <? else : ?>
                                                <div class="product-card__badge"></div>
                                        <? endif; ?>

                                       <!-- Значок скидки -->
                                       <?php if ($item['DISCOUNT_PERCENT'] > 0): ?>
                                                <div class="product-card__badge">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="Скидка">
                                                </div>
                                        <? else : ?>
                                                <div class="product-card__badge"></div>
                                        <? endif; ?>

                                        <!-- Значок экологичности -->
                                        <?php if (!empty($item['PROPERTIES']['PR100']['VALUE'])): ?>
                                                <div class="product-card__badge">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="Эко">
                                            </div>
                                        <? else : ?>
                                                <div class="product-card__badge"></div>
                                        <? endif; ?>   
                                        </div>

										<a href="<?=$item['URL']?>" class="product-card__img"><img src="<?=$item['IMAGE']?>" alt=""></a>
                                        <div class="product-card__title"> 
                                            <a href="<?=$item['URL']?>" class="text21 text14-mob"><?=$item['NAME']?></a>
                                        </div>
                                        <div class="product-card__prices" style="min-height: 45px;">
                                            <div class="product-card__price">
                                            <?=$item['PRICE']?> Р
                                            </div>                                          
                                            <div class="product-card__price2">
                                            <?if($item['DISCOUNT_PERCENT'] > 0):?>
                                                <?=$item['OLD_PRICE']?> Р
                                            <?endif;?>
                                            </div>
                                            <a style="
                                            display: flex; 
                                            -webkit-box-align: center; 
                                            -ms-flex-align: center; 
                                            align-items: center; 
                                            -webkit-box-pack: center; 
                                            -ms-flex-pack: center; 
                                            justify-content: center; 
                                            padding: 0 1.75em; 
                                            height: 2.625em; 
                                            background-color: #f48729; 
                                            color: #fefefe; 
                                            font-weight: 500; 
                                            text-transform: uppercase; 
                                            font-family: 'PF Agora Sans Pro', sans-serif; 
                                            border-radius: .4375em; 
                                            margin-top: auto;
                                            " class="addtobasket btn btn_green" href="#" id="ajaxaction=add&ajaxaddid=<?=$item['ID']?>">КУПИТЬ</a>
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