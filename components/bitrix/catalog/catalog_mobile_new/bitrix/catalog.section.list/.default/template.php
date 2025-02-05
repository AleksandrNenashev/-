<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);

global $sect_id, $sidebar_menu;
$sect_id = $arResult['SECTION']['ID'];
$sidebar_menu['SELECTED']['TEXT'] = $arResult['SECTION']['NAME'];

if (!empty($arResult['SECTIONS'])) {
    global $titleText;
    $titleText = $arResult['SECTION']['DESCRIPTION'];

    function AfterTitleText() {
        global $titleText;
        return $titleText;
    }
}
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
<?php if (!empty($arResult['SECTIONS'])): ?>

<div class="page-top">
    <div class="container _type2">
        <div class="breadcrumbs">
            <a href="/">Интернет-магазин</a>
            <a href="/catalog/" title="Каталог">Каталог</a>
        </div>
    </div>
</div>

<div class="catalog m-section">
    <div class="container _type2">
        <div class="h2 text-center">
            Каталог белорусской мебели<br> с ценами
        </div>

        <?php foreach ($arResult['SECTIONS'] as $arSection): ?>
            <div class="catalog-group">
                <div class="line-title"><a href="<?=$arSection["SECTION_PAGE_URL"];?>"><?=$arSection['NAME'] ?></a></div>
                <div class="sales-slider slider">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($arSection['ELEMENTS'] as $arItem): ?>
                                <div class="swiper-slide">
                                    <div class="product-card">
                                        <?if($arItem['PROPERTIES']['PRICE_LOWER']['VALUE'] == 'да'){?>
                                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/req.png" alt="Возможно изготовление по вашим размерам." class="product-card__request">  
                                        <?}?>
                                        <div class="product-card__badges">
                                            <?php if ($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'): ?>
                                                <div class="product-card__badge">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="Новинка">
                                                </div>
                                            <? else : ?>
                                                <div class="product-card__badge"></div>
                                            <? endif; ?>

                                            <?php if ($arItem['PRICES']['RUB']['DISCOUNT_DIFF_PERCENT'] > 0): ?>
                                                <div class="product-card__badge">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="Скидка">
                                                </div>
                                            <? else : ?>
                                                <div class="product-card__badge"></div>
                                            <? endif; ?>

                                            <?php if (!empty($arItem['PROPERTIES']['PR100']['VALUE'])): ?>
                                                <div class="product-card__badge">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="Эко">
                                            </div>
                                                <? else : ?>
                                                <div class="product-card__badge"></div>
                                            <? endif; ?>
                                        </div>

                                        <a href="<?=$arItem['DETAIL_PAGE_URL'] ?>" class="product-card__img">
                                            <img src="<?=$arItem['PREVIEW_PICTURE_SRC'] ?>" alt="">
                                        </a>

                                        <div class="product-card__title">
                                            <a href="<?=$arItem['DETAIL_PAGE_URL'] ?>" class="text21 text14-mob">
                                                <?= $arItem['NAME'] ?>
                                            </a>
                                        </div>

                                        <div class="product-card__prices" style="min-height: 45px;">
                                            <div class="product-card__price">
                                                <?= $arItem['PRICES']['RUB']['PRINT_DISCOUNT_VALUE'] ?>
                                            </div>
                                            <?php if ($arItem['PRICES']['RUB']['DISCOUNT_DIFF_PERCENT'] > 0): ?>
                                                <div class="product-card__price2">
                                                    <?= $arItem['PRICES']['RUB']['PRINT_VALUE_NOVAT'] ?>
                                                </div>
                                            <? endif; ?>
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
                                            " class="addtobasket btn btn_green" href="#" id="add_<?=$arItem['ID']?>">КУПИТЬ</a>                                         
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>  
function ajaxpostshow(url, data, selector) {
    $.post(url, data, function (response) {
        if (response.status === 'success') {
            console.log(response.message);
            $(selector).text(response.basket_count); // Обновляем счётчик корзины

            // Скролл вверх до корзины
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        } else {
            console.error(response.message);
        }
    }).fail(function () {
        console.error('Ошибка AJAX-запроса.');
    });
}

function ajax_init(selector) {
    $(document).off("click", selector).on("click", selector, function () {
        var addbasketid = $(this).attr('id').replace('add_', '');
        ajaxpostshow("/includes/small_basket_mob.php", { ajaxaddid: addbasketid, ajaxaction: 'add' }, ".cart-counter");
        return false;
    });
}

$(document).ready(function () {
    ajax_init(".addtobasket");
});
</script>
