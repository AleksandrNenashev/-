<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>

<style>
.header-action__btn {
    position: relative;
}
.cart-counter {
    position: absolute;
    top: 0;
    right: 0;
    background-color: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    border-radius: 50%;
    width: 20px; /* Диаметр кружка */
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translate(50%, -50%);
}
</style>	

<a href="<?=$arParams["PATH_TO_BASKET"]?>" class="header-action__btn left_basket_small">
    <img src="<?= SITE_TEMPLATE_PATH ?>/img/cart.svg" alt="">
	<span class="cart-counter left_basket_small">
	<?=$arResult["NUM_PRODUCTS"]?>
	</span>
</a>
<script>
	BX.ready(function(){
		BX.onCustomEvent('OnBasketRefresh', <?=\Bitrix\Main\Web\Json::encode($arResult)?>);
	});
</script>