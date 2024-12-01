<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);


global $Add_Snipets;
$Add_Snipets = '<meta property="og:title" content="'.$arResult["NAME"]." ".$arResult["MIN_PRICE"]["PRINT_VALUE"].'" />';
function Add_Snipets(){
	global $Add_Snipets;
	return $Add_Snipets;
}


//для отзыва
global $id_tovara;
$id_tovara = $arResult['ID'];

$APPLICATION->SetPageProperty("keywords", $arResult['PROPERTIES']['META_KEYWORDS']['VALUE']);
$APPLICATION->SetPageProperty("description", $arResult['PROPERTIES']['META_DESCRIPTION']['VALUE']);
$APPLICATION->SetPageProperty("title", $arResult['PROPERTIES']['META_TITLE']['VALUE']);

?>
<div class="l-cols4" itemscope itemtype="http://schema.org/Product">
	<h2 style="display: none;" itemprop="name"><?=$arResult["NAME"];?></h2>
	<div class="l-col1 js-tab-group">
		<div class="gallery js-gallery">
			<div class="gallery__img ">
		
				
				<a href="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" class="js-fancybox js-gallery-img" rel="gallery321">
				<? 
				//echo "<pre>";print_r($arResult['PREVIEW_PICTURE']);echo "</pre>";
				?>
					<img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult['PREVIEW_PICTURE']["ALT"]?>" title="<?=$arResult['PREVIEW_PICTURE']["TITLE"]?>" style="display: block; margin: 0 auto; max-height: 340px;" itemprop="image" />
				</a>
				
				<div class="badge-wrap">
					<?if($arResult['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'){?>
						<span class="badge">
							new
							<img src="/upload/img/badge-new.png" alt="">
						</span>
					<?}?>
					<?if($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0){?>
						<span class="badge">
							-<?=$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%
							<img src="/upload/img/badge-discount.png" alt="">
						</span>
					<?}?>
					<?if(!empty($arResult['PROPERTIES']['PR100']['VALUE'])){?>
						<span class="badge js-tooltip-key" data-title="100% <?=$arResult['PROPERTIES']['PR100']['VALUE']?>">
							<img src="/upload/img/badge-eco.png" alt="">
						</span>
					<?}?>
				</div>
				<span class="gallery__zoom"></span>
					 <?if($arResult['PROPERTIES']['PRICE_LOWER']['VALUE'] == 'да'){?>
							<div class="lower_price lower_price_detail">
								<span class="lower_price_text">Хотите цену ниже? <br>Звоните!</span>
								<img  src="/upload/img/rubl1.png" alt="Хотите цену ниже?">
							</div>
						<?}?>
			</div>
			<div class="gallery__preview js-gallery-preview">
				<a rel="" href="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" class="js-fancybox is-active"><img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt=""></a>
				<? foreach($arResult['PROPERTIES']['DET_PIC']['VALUE'] as $key => $pic){?>
					<?$src = CFile::GetPath($pic);?>
					<a rel="gallery321" class="js-fancybox" href="<?=$src?>"><img src="<?=$src?>" alt=""></a>
				<?} 
				if(!empty($arResult['PROPERTIES']['VIDEO']['VALUE'])) { ?>
					<?foreach($arResult['PROPERTIES']['VIDEO']['~VALUE'] as $item){
						if(!preg_match("/v=(?<vid>[^\&]*)/",$item,$matches)) continue; 
					
					?>
					 	<a rel="gallery321" class="js-fancybox" href="https://www.youtube.com/embed/<?=$matches['vid']?>?rel=0&showinfo=0" data-rel="media"><img src="https://img.youtube.com/vi/<?=$matches['vid']?>/0.jpg" alt="" class="video__prev"></a>
					 	
			<?	} } ?>
			</div>

		</div>
		<div class="prod" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<?
			if(count($arResult['OFFERS']) <= 1){
				if(count($arResult['OFFERS']) == 1){?>
					<div class="prod__head">
						<div class="prod__meta">
							<?if($arResult['OFFERS'][0]['PROPERTIES']['AVAILABLE']['VALUE'] == 'В наличии'){?>
								<div class="prod__state is-available">В наличии</div>
							<?} else {?>
								<div class="prod__state is-order">Под заказ</div>
								<div class="prod__delivery"><?=$arResult['OFFERS'][0]['PROPERTIES']['POSTAVKA']['VALUE']?></div>
							<?}?>
						</div>
					</div>
					<div class="prod__price">
						
						<?if($arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?>
							<div class="old-price">
								Старая цена: <span><?=$arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['PRINT_VALUE']?></span>
							</div>
						<?}?>
						<div class="prod__sum">
							<?=$arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE']?>
						</div>
						<?
						//echo "<pre>";print_r();echo "</pre>";
						?>
						<span style="display: none;" itemprop="price">
							<?=$arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]["DISCOUNT_VALUE"]?>
						</span>
						
						<span style="display: none;" itemprop="priceCurrency">
							<?=$arResult['OFFERS'][0]["CATALOG_CURRENCY_1"]?>
						</span>
						<a id="ajaxaction=add&ajaxaddid=<?=$arResult['OFFERS'][0]['ID']?>" href="#" class="addtobasket btn btn_green btn_basket">В корзину</a>
						<!--<div><a class="buy-click js-popup-link" href="js-popup-buy" data-id="<?=$arResult['OFFERS'][0]['ID']?>">Быстро купить в 1 клик</a></div>-->
						
						<div class="bk_product" style="display: none;">
							<span class="bk_name" style="display: none;"><?=$arResult["NAME"];?></span>
							<span class="bk_price"><?=$arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE']?></span>
						</div>
						 <div><a class="buy-click js-popup-link2" href="js-popup-buy" data-id="<?$arFields['ID']?>'">Быстро купить в 1 клик</a></div> 
		 <a  href="/rassrochka/"  class="rassrochka" >В рассрочку</a> 
						<!--<div class="bk_container" partner="178601">
							<div class="bk_buy_button rr" onclick="javascript:bk_frame_show(this)">В кредит</div>
						</div>-->
						<link rel="stylesheet" type="text/css" href="https://birjakreditov.com/bkapi/bk.css"/>
						<script src="https://birjakreditov.com/bkapi/bk.js"></script>
					</div>
				<?} else {?>
					<div class="prod__head">
						<div class="prod__meta">
							<div class="prod__state is-order">Под заказ</div>
						</div>
					</div>
					<div class="prod__price">
						<a href="#" class="btn btn_green btn_basket" disabled>В корзину</a>
					</div>
				<?}
			} else {
				require_once($_SERVER["DOCUMENT_ROOT"]."/catalog/getSkuProd.php");
			}?>
		</div>
		
		<ul class="tab-simple js-tab">
			<li>
				<a href="js-tab1"><span>Характеристики</span></a>
			</li>
			<li>
				<a href="js-tab2"><span>Описание</span></a>
			</li>
			<li>
				<a href="js-tab3"><span>Отзывы <?
				$arSelect_set = Array("ID");
				$arFilter_set = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", 'PROPERTY_ELEM_ID' => $arResult['ID']);
				$res_set = CIBlockElement::GetList(Array(), $arFilter_set);
				if ($count = $res_set->SelectedRowsCount())
					echo "(".$count.")";
				?></span></a>
			</li>
			<li>
				<a href="js-tab4"><span>Видео <?if(count($arResult['PROPERTIES']['VIDEO']['~VALUE'])){echo "(".count($arResult['PROPERTIES']['VIDEO']['~VALUE']).")";}?></span></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="js-tab-cont js-tab1">
				<ul class="prod-param prod-param_left">
					<?$k = 0;?>
					<?foreach($arResult['DISPLAY_PROPERTIES'] as $key => $prop){?>
						<?$k++;?>
						<li>
							<?if($key == 'PR100'){?>
								<strong>Материал</strong>
							<?} else {?>
								<strong><?=$prop['NAME']?></strong>
							<?}?>
							<?if($key == 'MANUFACTURER'){?>
								<span><a href="<?=$arResult['MANUFACTURER']['SECTION_PAGE_URL']?>"><?=$prop['VALUE']?></a></span>
							<?}elseif($key == 'SERIES'){?>
								<span><a href="<?=$arResult['SERIES']['DETAIL_PAGE_URL']?>"><?=$prop['VALUE']?></a></span>
							<?} else {?>
								<?if(is_array($prop['VALUE'])){?>
									<span><?foreach($prop['VALUE'] as $v){echo $v.' ';}?></span>
								<?} else {?>
									<span><?=$prop['VALUE']?></span>
								<?}?>
							<?}?>
						</li>
						<?if((count($arResult['DISPLAY_PROPERTIES'])/2 < $k+1) && $n != 'y'){$n = 'y'; echo '</ul><ul class="prod-param prod-param_right">';}?>
					<?}?>
					<?if(count($arResult['OFFERS']) <= 1){?>
						<?$k = 0;?>
						<?foreach($arResult['OFFERS'][0]['DISPLAY_PROPERTIES'] as $key => $prop){?>
	<script>
		$( document ).ready(function() {
			var additional = '<li class="additional"><strong><?=$prop['NAME']?></strong><span><?=$prop['VALUE']?></span></li>';
			var left = $('ul.prod-param_left li').length,
				right = $('ul.prod-param_right li').length;
			if(right > left){
				$('.prod-param_left').append(additional);
			} else {
				$('.prod-param_right').append(additional);
			}
		});
	</script>

						<?}?>
					<?}?>
				</ul>
			</div>
			<div class="js-tab-cont js-tab2">
				<div class="prod-descr" itemprop="description"><?=$arResult['DETAIL_TEXT']?></div>
			</div>
			<div class="js-tab-cont js-tab3">
				<?
				global $arReviFil;
				$arReviFil = array('PROPERTY_ELEM_ID' => $arResult['ID']);
				?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list", 
					"review", 
					array(
						"IBLOCK_TYPE" => "reviews",
						"IBLOCK_ID" => "3",
						"NEWS_COUNT" => "20",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_ORDER1" => "DESC",
						"SORT_BY2" => "ID",
						"SORT_ORDER2" => "ASC",
						"FILTER_NAME" => "arReviFil",
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
						"PROPERTY_CODE" => array(
							0 => "RATE",
							1 => "",
						),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "N",
						"AJAX_OPTION_HISTORY" => "N",
						"CACHE_TYPE" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_FILTER" => "N",
						"CACHE_GROUPS" => "N",
						"PREVIEW_TRUNCATE_LEN" => "",
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"INCLUDE_SUBSECTIONS" => "N",
						"PAGER_TEMPLATE" => ".default",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => "Новости",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "N",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"AJAX_OPTION_ADDITIONAL" => ""
					),
					false
				);?>
			</div>
			<div class="js-tab-cont js-tab4">
					<a rel="gallery321" class="js-fancybox js-video fancybox.iframe" href="https://www.youtube.com/embed/<?=$matches['vid']?>?rel=0&showinfo=0" data-rel="media"><img src="https://img.youtube.com/vi/<?=$matches['vid']?>/0.jpg" alt="" class="video__prev"></a>
			</div>
		</div>
		<div class="social social-likes" style="margin: 20px 0 0; width: 100%;">
			<div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
			<div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
			<div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
		</div>
		<div class="set"></div>
	</div>
	<div class="l-col2">
		<div class="add-info">
			<div class="add-info__head">
				<div class="add-info__delivery">
					<i class="icon-delivery"></i>
					<span>
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/includes/detail_right_deliv.php",
								"EDIT_TEMPLATE" => ""
							),
							false
						);?>
					</span>
				</div>
			</div>
			<div class="add-info__body">
				<a class="js-popup-link" href="js-popup-credit">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/includes/detail_right_credit_title.php",
							"EDIT_TEMPLATE" => ""
						),
						false
					);?>
				</a>

				<div class="add-info__text">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/includes/detail_right_credit_text.php",
							"EDIT_TEMPLATE" => ""
						),
						false
					);?>
				</div>
				<div class="wtf" <?if(empty($arResult['PROPERTIES']['INSTR']['VALUE'])){?>style="border:none;"<?}?>>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/includes/detail_right_manager.php",
							"EDIT_TEMPLATE" => ""
						),
						false
					);?>
				</div>
			</div>
			<?if(!empty($arResult['PROPERTIES']['INSTR']['VALUE'])){?>
				<?$src = CFile::GetPath($arResult['PROPERTIES']['INSTR']['VALUE']);?>
				<div class="add-info__footer">
					<a href="<?=$src?>" class="doc-link">Инструкция по сборке</a>
				</div>
			<?}?>
		</div>
		<?/*
		<div class="slider-add"> 
			<div class="js-slider-add">
<!--
				<div>
					<a href="js-popup-subscribe" class="js-popup-link">
						<span>Подпишись и подпиши 3 друзей и получи 20% скидку</span>
						<i class="icon-email"></i>
					</a>
				</div>
-->
				<?if(!empty($arResult['PROPERTIES']['PODAROK']['VALUE'])){?>
					<?
					global $gift;
					$gift = $arResult['GIFT'];
					?>
					<div>
						<a href="js-popup-gift" class="js-popup-link">
							<span><?=$arResult['PROPERTIES']['PODAROK']['VALUE']?> в подарок!</span>
							<i class="icon-gift"></i>
						</a>
					</div>
				<?}?>
			</div>
		</div>
		
		<div class="yandex-market yandex-market_static">
			<img src="/upload/img/yandex-market.png" alt="">
			<div><a href="#">Отзывы о магазине</a></div>
		</div>
		*/?>
<?if(!empty($arResult['RECOMMEND2'])){?>
		<div class="vertical-slider">
			<div class="vertical-slider__title">
				<span>похожие товары</span>
			</div>
			<div class="cycle-slideshow" 
			data-cycle-fx=carousel
			data-cycle-timeout=0
			data-cycle-loader=wait
			data-cycle-prev=".js-prev"
			data-cycle-next=".js-next"
			data-cycle-auto-height=container
			data-cycle-slides="> div"
			data-cycle-carousel-visible=1  
			data-cycle-carousel-vertical=true
			>
				<div>
				
				<?$k = 0;?>
				<?foreach($arResult['RECOMMEND2'] as $rec){?>
					<?$k++; if($k == 2){echo '</div><div>'; $k = 0;}?>
					<div class="vertical-slider__item">
						<div class="vertical-slider__img">
							<a href="<?=$rec['DETAIL_PAGE_URL']?>">
								<img height="112" src="<?=$rec['PREVIEW_PICTURE']['SRC']?>" alt="">
							</a>
						</div>
						<a href="<?=$rec['DETAIL_PAGE_URL']?>"><?=$rec['NAME']?></a>
						<div class="price"><?=$rec['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE']?></div>
						<?if($rec['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?><div class="old-price"><span><?=$rec['PRICES'][$_SESSION['region_price']]['PRINT_VALUE_NOVAT']?></span></div><?}?>
					</div>
				<?}?>
				</div>

			</div>
			<button class="btn-prev js-prev"></button>
			<button class="btn-next js-next"></button>
		</div>
<?}?>
	</div>
</div>
<?if(!empty($arResult['RECOMMEND'])){?>
<div class="item-slider">
	<div class="tab-wrap">
		<ul class="tab">
			<li class="tab__item is-active">
				<a><span>сопутствующие товары</span></a>
			</li>
		</ul>
	</div>
	<div class="js-slider-items2 slider-with-arr"> 
		<?foreach($arResult['RECOMMEND'] as $rec){?>
			<div class="item item_no-hover">
				<div class="badge-wrap">
					<?if($rec['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'){?>
						<span class="badge">
							new
							<img src="/upload/img/badge-new.png" alt="">
						</span>
					<?}?>
					<?if($rec['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?>
						<span class="badge">
							-<?=$rec['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT']?>%
							<img src="/upload/img/badge-discount.png" alt="">
						</span>
					<?}?>
					<?if(!empty($rec['PROPERTIES']['PR100']['VALUE'])){?>
						<span class="badge js-tooltip-key" data-title="100% <?=$rec['PROPERTIES']['PR100']['VALUE']?>">
							<img src="/upload/img/badge-eco.png" alt="">
						</span>
					<?}?>
				</div>
				<div class="item__in">
					<div class="item__img">
						<a href="<?=$rec['DETAIL_PAGE_URL']?>"><img src="<?=$rec['PREVIEW_PICTURE']['SRC']?>" alt=""></a>
					</div>
					<div class="item__main">
						<a href="<?=$rec['DETAIL_PAGE_URL']?>" class="prod-title"><?=$rec['NAME']?></a>
						<div class="price"><?=$rec['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE']?></div>
						<?if($rec['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?><div class="old-price"><span><?=$rec['PRICES'][$_SESSION['region_price']]['PRINT_VALUE_NOVAT']?></span></div><?}?>
					</div>
				</div>
			</div>
		<?}?>
	</div>
</div>
<?}?>
<?if(count($arResult['OFFERS']) == 1){?>
<?
$arSelect_set = Array("ID");
$arFilter_set = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y");
$res_set = CIBlockElement::GetList(Array(), $arFilter_set, false, false, $arSelect_set);
while($ob_set = $res_set->GetNextElement())
{
	$arSet = $ob_set->GetFields();
	$in_set = CCatalogProductSet::getAllSetsByProduct($arSet['ID'], CCatalogProductSet::TYPE_SET);
	foreach($in_set as $set){
		foreach($set['ITEMS'] as $set_items){
			//echo $set_items['ITEM_ID'].'='.$arFields['ID'].'<br>';
			if($set_items['ITEM_ID'] == $arResult['OFFERS'][0]['ID']){
				$this_in_sets[] = $in_set;
			}
		}
	}
}
?>
<?echo '<pre style="display:none;">'; print_r($this_in_sets); echo '</pre>';?>
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
					set = set + '<div class="kit-items__discount">Скидка <span><?=round(100 - $el_arr_set[$se['ITEM_ID']]['DISCOUNT_VALUE']*100/$total)?>%</span><br /> Экономия <strong><?=CurrencyFormat(($total - $el_arr_set[$se['ITEM_ID']]['DISCOUNT_VALUE']), "RUB")?></strong></div>';
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
<?}?>
<div class="catalog-back"><a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" class="link-prev is-orange">Назад в каталог</a></div>
<?//echo '<pre style="display:none;">'; print_r($arResult); echo '</pre>';?>
<?//echo '<pre style="display:none;">'; print_r($in_set); echo '</pre>';?>
