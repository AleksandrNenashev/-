<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

global $USER;
$arSelect = Array("ID", "NAME", "CATALOG_GROUP_".$_SESSION['region_price_id'], "PROPERTY_CML2_LINK", "PROPERTY_SIZE", "PROPERTY_AVAILABLE", "PROPERTY_POSTAVKA");
$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $_POST['PARENT_ID'], "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0);

foreach($_POST['SKU'] as $key => $val){
		$prop_name = 'PROPERTY_'.$key;
		$arFilter[$prop_name] = $val;
}
$res = CIBlockElement::GetList(array("CATALOG_PRICE_".$_SESSION['region_price_id'] => "DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
		$arFields['ID'],
		$USER->GetUserGroupArray(),
		"N",
		$arFields['CATALOG_GROUP_ID_'.$_SESSION['region_price_id']]
	);

	$discountPrice = CCatalogProduct::CountPriceWithDiscount(
		$arFields["CATALOG_PRICE_".$_SESSION['region_price_id']],
		$arFields["CATALOG_CURRENCY_".$_SESSION['region_price_id']],
		$arDiscounts
	);

	$el_arr[$arFields['ID']]['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($discountPrice, 'RUB');

	if(intval($discountPrice) < intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']])){
		echo '<div class="old-price">Старая цена: <span>';
		echo CurrencyFormat($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']], 'RUB');
		echo '</span></div>';
	}
	echo '<div class="prod__sum">';
    echo '<meta itemprop="price" content = "' . (int)$discountPrice . '">';
	echo CurrencyFormat($discountPrice, 'RUB');
	echo '</div>';
	
	echo '<div class="bk_product" style="display: none;">';
	echo '<span class="bk_name" style="display: none;">';
	echo $arFields["NAME"];
	echo '</span>';
	echo '<span class="bk_price">';
	echo CurrencyFormat($discountPrice, 'RUB');
	echo '</span>';
	echo '</div>';
	
	
	echo '<a class="addtobasket btn btn_green btn_basket" href="#" id="ajaxaction=add&ajaxaddid='.$arFields['ID'].'">В корзину</a>';
	echo '<div><a class="buy-click js-popup-link2" href="js-popup-buy" data-id="'.$arFields['ID'].'" data-iblock-id="2">Быстро купить в 1 клик</a></div>';
		echo '<a  href="/rassrochka/"  class="rassrochka" >В рассрочку</a>';
	echo '<!--<div style="margin-top: 5px;"><div class="bk_container" partner="178601">
			<div class="bk_buy_button" onclick="javascript:bk_frame_show(this)">В кредит</div>
		 </div>-->';
}
?>
<script>
	$(".addtobasket").on("click", function(){
		var addbasketid = $(this).attr('id');
		ajaxpostshow("/includes/small_basket.php", addbasketid, ".header__cart" );
		return false;
	});

	$('.prod__meta').removeClass('disabled');
	<?switch($arFields['PROPERTY_AVAILABLE_VALUE']){
		case 'В наличии':
			?>
			$('.prod__meta').html('<div class="prod__state is-available">В наличии</div>');<?
			break;
		case 'Под заказ' :
			?>$('.prod__meta').html('<div class="prod__state is-order">Под заказ</div><div class="prod__delivery"><?=$arFields['PROPERTY_POSTAVKA_VALUE']?></div>');<?
			break;
		case '' :
			?>$('.prod__meta').html('<div class="prod__state is-order">Под заказ</div><div class="prod__delivery"><?=$arFields['PROPERTY_POSTAVKA_VALUE']?></div>');<?
			break;
	}?>
</script>
<?
$arSelect_set = Array("ID");
$arFilter_set = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y");
$res_set = CIBlockElement::GetList(Array(), $arFilter_set, false, false, $arSelect_set);
$this_in_sets = array();
while($ob_set = $res_set->GetNextElement())
{
	$arSet = $ob_set->GetFields();
	$in_set = CCatalogProductSet::getAllSetsByProduct($arSet['ID'], CCatalogProductSet::TYPE_SET);
	foreach($in_set as $set){
		foreach($set['ITEMS'] as $set_items){
			//echo $set_items['ITEM_ID'].'='.$arFields['ID'].'<br>';
			if($set_items['ITEM_ID'] == $arFields['ID']){
				$this_in_sets[] = $in_set;
			}
		}
	}
}
?>
<?//echo '<pre style="display:none;">'; print_r($this_in_sets); echo '</pre>';?>
<script>
<?if(count($this_in_sets) > 0){?>
	var set = '<div class="kit-items"><div class="kit-items__title"><span>купите в комплекте со скидкой</span></div><div class="js-slider-kit slider-with-arr">';
	<?foreach($this_in_sets as $set){?>
	<?foreach($set as $se){

				$arSelect = Array("ID", "NAME", "CATALOG_GROUP_".$_SESSION['region_price_id'], "CATALOG_PRICE_".$_SESSION['region_price_id'], "PROPERTY_CML2_LINK", "PREVIEW_PICTURE", "PROPERTY_SIZE", "PROPERTY_PR100", "PROPERTY_NEWPRODUCT");
				$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID" => $se['ITEM_ID'], "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0);
				$res = CIBlockElement::GetList(array("CATALOG_PRICE_".$_SESSION['region_price_id'] => "DESC"), $arFilter, false, false, $arSelect);
				while($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					//echo '<pre style="display:block;">'; print_r($arFields); echo '</pre>';
					$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
						$arFields['ID'],
						$USER->GetUserGroupArray(),
						"N",
						$arFields['CATALOG_GROUP_ID_'.$_SESSION['region_price_id']]
					);
			
					$discountPrice = CCatalogProduct::CountPriceWithDiscount(
						$arFields["CATALOG_PRICE_".$_SESSION['region_price_id']],
						$arFields["CATALOG_CURRENCY_".$_SESSION['region_price_id']],
						$arDiscounts
					);
					if(!empty($discountPrice)){
						$with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']][$arFields['ID']] = $discountPrice;
					}
			
					$el_arr_set[$arFields['ID']]['VALUE_NOVAT'] = intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']]);
					$el_arr_set[$arFields['ID']]['DISCOUNT_VALUE'] = intval($discountPrice);
					$el_arr_set[$arFields['ID']]['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($discountPrice, 'RUB');
			
					$el_arr_set[$arFields['ID']]['PROPERTIES']['SIZE']['VALUE'] = $arFields['PROPERTY_SIZE_VALUE'];
			
					if(intval($discountPrice) < intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']])){
						$el_arr_set[$arFields['ID']]['DISCOUNT_DIFF_PERCENT'] = 100 - round($discountPrice * 100 / intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']]));
						$el_arr_set[$arFields['ID']]['PRINT_VALUE_NOVAT'] = CurrencyFormat($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']], 'RUB');
					}
					if(count($with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']]) > 1){
						$el_arr_set[$arFields['ID']]['FROM'] = 'Y';
					} else {
						$el_arr_set[$arFields['ID']]['ONE'] = intval($arFields['ID']);
					}
				}

		?>
		set = set + '<div>';
			<?$k = 0;?>
			<?foreach($se['ITEMS'] as $it){
				global $USER;
				$arSelect = Array("ID", "NAME", "CATALOG_GROUP_".$_SESSION['region_price_id'], "CATALOG_PRICE_".$_SESSION['region_price_id'], "PROPERTY_CML2_LINK", "PREVIEW_PICTURE", "PROPERTY_SIZE", "PROPERTY_PR100", "PROPERTY_NEWPRODUCT");
				$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "ID" => $it, "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0);
				$res = CIBlockElement::GetList(array("CATALOG_PRICE_".$_SESSION['region_price_id'] => "DESC"), $arFilter, false, false, $arSelect);
				while($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					//echo '<pre style="display:block;">'; print_r($arFields); echo '</pre>';
					$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
						$arFields['ID'],
						$USER->GetUserGroupArray(),
						"N",
						$arFields['CATALOG_GROUP_ID_'.$_SESSION['region_price_id']]
					);
			
					$discountPrice = CCatalogProduct::CountPriceWithDiscount(
						$arFields["CATALOG_PRICE_".$_SESSION['region_price_id']],
						$arFields["CATALOG_CURRENCY_".$_SESSION['region_price_id']],
						$arDiscounts
					);
					if(!empty($discountPrice)){
						$with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']][$arFields['ID']] = $discountPrice;
					}
			
					$el_arr[$arFields['ID']]['VALUE_NOVAT'] = intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']]);
					$el_arr[$arFields['ID']]['DISCOUNT_VALUE'] = intval($discountPrice);
					$el_arr[$arFields['ID']]['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($discountPrice, 'RUB');
			
					$el_arr[$arFields['ID']]['PROPERTIES']['SIZE']['VALUE'] = $arFields['PROPERTY_SIZE_VALUE'];
			
					if(intval($discountPrice) < intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']])){
						$el_arr[$arFields['ID']]['DISCOUNT_DIFF_PERCENT'] = 100 - round($discountPrice * 100 / intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']]));
						$el_arr[$arFields['ID']]['PRINT_VALUE_NOVAT'] = CurrencyFormat($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']], 'RUB');
					}
					if(count($with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']]) > 1){
						$el_arr[$arFields['ID']]['FROM'] = 'Y';
					} else {
						$el_arr[$arFields['ID']]['ONE'] = intval($arFields['ID']);
					}
					$el_arr['PROPERTY_CML2_LINK_VALUE'] = $arFields['PROPERTY_CML2_LINK_VALUE'];
				}

				?>
<?
$res_par = CIBlockElement::GetByID($el_arr['PROPERTY_CML2_LINK_VALUE']);
if($ar_res = $res_par->GetNext()){

	$parent = $ar_res;
	$parent['PREVIEW_PICTURE_SRC'] = CFile::GetPath($parent['PREVIEW_PICTURE']);
}?>
				<?$k++;?>
				set = set + '<div class="item item_no-hover">';
					set = set + '<div class="badge-wrap">';
						<?if($parent['PROPERTY_NEWPRODUCT'] == "Да"){?>
							set = set + '<span class="badge">new<img src="/upload/img/badge-new.png" alt=""></span>';
						<?}?>
						<?if($el_arr[$it['ITEM_ID']]['DISCOUNT_DIFF_PERCENT'] > 0){?>
							set = set + '<span class="badge">-15%<img src="/upload/img/badge-discount.png" alt=""></span>';
						<?}?>
						//set = set + '<span class="badge js-tooltip-key" data-title="100% дерево"><img src="/upload/img/badge-eco.png" alt=""></span>';
					set = set + '</div>';
					set = set + '<div class="item__in">';
						set = set + '<div class="item__img">';
							set = set + '<a href="<?=$parent['DETAIL_PAGE_URL']?>"><img src="<?=CFile::GetPath($parent['PREVIEW_PICTURE_SRC']);?>" alt=""></a>';
						set = set + '</div>';
						set = set + '<div class="item__main">';
							set = set + '<a href="<?=$parent['DETAIL_PAGE_URL']?>" class="prod-title"><?=$parent['NAME']?></a>';
							set = set + '<div class="price"><?=$el_arr[$it['ITEM_ID']]['PRINT_DISCOUNT_VALUE']?></div>';
						set = set + '</div>';
					set = set + '</div>';
					<?if($k == 1){?>
						set = set + '<i class="icon-plus">+</i>';
					<?} else {?>
						set = set + '<i class="icon-equ">=</i>';
					<?}?>
				set = set + '</div>';
<?$total = $total + $el_arr[$it['ITEM_ID']]['DISCOUNT_VALUE'];?>
			<?}?>
			set = set + '<div class="item">';
				set = set + '<div class="kit-items__total">';
					set = set + '<div class="kit-items__discount">Скидка <span><?=round(100 - $el_arr_set[$se['ITEM_ID']]['DISCOUNT_VALUE']*100/$total)?>%</span> <br />Экономия <strong><?=CurrencyFormat(($total - $el_arr_set[$se['ITEM_ID']]['DISCOUNT_VALUE']), "RUB")?></strong></div>';
					set = set + '<div class="kit-items__price"><?=$el_arr_set[$se['ITEM_ID']]['PRINT_DISCOUNT_VALUE']?></div>';
					set = set + '<a id="ajaxaction=add&ajaxaddid=<?=$se['ITEM_ID']?>" href="#" class="addtobasket2 btn btn_green btn_basket">В корзину</a>';
				set = set + '</div>';		
			set = set + '</div>';
		set = set + '</div>';
<?unset($total);?>
	<?}?>
	<?}?>
	set = set + '</div></div>';
<?}else{?>
	var set = '';
<?}?>
$('.set').html(set);
$('.js-slider-kit').slick({
	slidesToShow: 1,
	dots: true,
	infinite: false,
	speed: 300,
	touchMove: true,
	slidesToScroll: 1,
});
ajax_init2();
</script>
<?echo '<pre style="display:none;">'; print_r($el_arr); echo '</pre>';?>