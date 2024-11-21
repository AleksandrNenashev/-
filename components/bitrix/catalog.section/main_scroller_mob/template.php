<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="scroller-wrap">
	<div class="scroller">
		<div class="tab-wrap">
			<ul class="tab">
				<li class="tab__item <?if($_POST['tab'] == 'pop' or empty($_POST['tab'])){?>is-active<?}?>">
					<a href="pop" class="ajax_tab"><span>Популярные товары</span></a>
				</li>
				<li class="tab__item <?if($_POST['tab'] == 'sale'){?>is-active<?}?>">
					<a href="sale" class="ajax_tab"><span>Большая скидка</span></a>
				</li>
				<li class="tab__item <?if($_POST['tab'] == 'new'){?>is-active<?}?>">
					<a href="new" class="ajax_tab"><span>Новинки</span></a>
				</li>
			</ul>
		</div> 
		<div class="scroller__in js-scroll-pane">
			<?foreach($arResult['ITEMS'] as $arItem){?>
				<div class="item item_hover">
					<div class="badge-wrap">
						<?if($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'){?>
							<span class="badge">
								new
								<img src="/upload/img/badge-new.png" alt="">
							</span>
						<?}?>
						<?if($arItem['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?>
							<span class="badge">
								-<?=$arItem['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT']?>%
								<img src="/upload/img/badge-discount.png" alt="">
							</span>
						<?}?>
						<?if(!empty($arItem['PROPERTIES']['PR100']['VALUE'])){?>
							<span class="badge js-tooltip-key" data-title="100% <?=$arItem['PROPERTIES']['PR100']['VALUE']?>">
								<img src="/upload/img/badge-eco.png" alt="">
							</span>
						<?}?>
					</div>
					<div class="item__in">
						<div class="item__img">
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img style="max-width: 98%;" height="170" src="<?=$arItem['PREVIEW_PICTURE']['RESIZE_SRC']?>" alt="<?=$arItem['NAME']?>"></a>
						</div>
						<div class="item__main">
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="prod-title"><?=$arItem['NAME']?></a>
							<div class="price"><?=$arItem['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE']?></div>
							<?if($arItem['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?><div class="old-price"><span><?=$arItem['PRICES'][$_SESSION['region_price']]['PRINT_VALUE_NOVAT']?></span></div><?}?>
							<?if(!empty($arItem['PRICES']['RUB']['ONE'])){?>
								<a class="addtobasket3 btn btn_green" href="#" id="ajaxaction=add&amp;ajaxaddid=<?=$arItem['PRICES']['RUB']['ONE']?>">В корзину</a>
							<?}?>
						</div>
					</div>
				</div>
			<?}?>
		</div>
	</div>
</div>


<div class="h2 text-center">
                        распродажа
                    </div>
                    <div class="sales-slider slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product-card">

                                        <div class="product-card__badges">

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="">
                                            </div>
                                        </div>
                                        <a href="" class="product-card__img">
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/product.webp" alt="">
                                        </a>
                                        <div class="product-card__title">
                                            <a href="" class="text21 text14-mob">
                                                Шкаф-витрина "Луи Филипп ОВ <br>
            28.01"
                                            </a>
                                        </div>
                                        <div class="product-card__prices">
                                            <div class="product-card__price">
                                                51 840 Р
                                            </div>
                                            <div class="product-card__price2">
                                                74 490 Р
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="swiper-slide">
                                    <div class="product-card">

                                        <div class="product-card__badges">

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="">
                                            </div>
                                        </div>
                                        <a href="" class="product-card__img">
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/product.webp" alt="">
                                        </a>
                                        <div class="product-card__title">
                                            <a href="" class="text21 text14-mob">
                                                Шкаф-витрина "Луи Филипп ОВ <br>
            28.01"
                                            </a>
                                        </div>
                                        <div class="product-card__prices">
                                            <div class="product-card__price">
                                                51 840 Р
                                            </div>
                                            <div class="product-card__price2">
                                                74 490 Р
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="swiper-slide">
                                    <div class="product-card">

                                        <div class="product-card__badges">

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="">
                                            </div>
                                        </div>
                                        <a href="" class="product-card__img">
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/product.webp" alt="">
                                        </a>
                                        <div class="product-card__title">
                                            <a href="" class="text21 text14-mob">
                                                Шкаф-витрина "Луи Филипп ОВ <br>
            28.01"
                                            </a>
                                        </div>
                                        <div class="product-card__prices">
                                            <div class="product-card__price">
                                                51 840 Р
                                            </div>
                                            <div class="product-card__price2">
                                                74 490 Р
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="swiper-slide">
                                    <div class="product-card">

                                        <div class="product-card__badges">

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="">
                                            </div>
                                        </div>
                                        <a href="" class="product-card__img">
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/product.webp" alt="">
                                        </a>
                                        <div class="product-card__title">
                                            <a href="" class="text21 text14-mob">
                                                Шкаф-витрина "Луи Филипп ОВ <br>
            28.01"
                                            </a>
                                        </div>
                                        <div class="product-card__prices">
                                            <div class="product-card__price">
                                                51 840 Р
                                            </div>
                                            <div class="product-card__price2">
                                                74 490 Р
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
<?//echo '<pre style="display:block;">'; print_r($arResult['ITEMS']); echo '</pre>';?>
<script>
$('.js-scroll-pane').jScrollPane();
$('.ajax_tab').on('click', function(){
	var post = 'tab='+$(this).attr('href');
	ajaxpostshow('/includes/main_ajax_block.php', post, '.ajax_block_holder');
	return false;
});
ajax_init3();
</script>