<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin('');
?>
<?$sum = 0;
$quantity = 0;
$list = '';
foreach($arResult['ITEMS'] as &$arItem){
	if(!empty($arItem['res'])){
		$find = $arItem['res']['PROPERTY_CML2_LINK_VALUE'];
	} else {
		$find = $arItem['PRODUCT_ID'];
	}
	$res = CIBlockElement::GetByID($find);
	if($ar_res = $res->GetNext()){
		$pic = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
		if($ar_res['IBLOCK_ID'] == 4){
			$url = '';
		} else {
			$url = 'href="'.$ar_res['DETAIL_PAGE_URL'].'"';
		}
	}

	$list .= '<div class="cart-item"><a '.$url.' class="cart-item__img"><img src="'.$pic.'" width="62" alt=""></a><div class="cart-item__info"><a '.$url.'>'.$arItem['NAME'].'</a><br /><span>'.$arItem['PRICE_FORMATED'].'</span></div></div>';
	$sum = $sum + ($arItem['PRICE']*$arItem['QUANTITY']);
	$quantity = $quantity + $arItem['QUANTITY'];
}?>


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
	<?=$quantity?>
	</span>
</a>





