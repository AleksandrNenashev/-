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
		
				
				<a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="js-fancybox js-gallery-img" rel="gallery321">
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
					<?if($arResult['MIN_PRICE2']['DISCOUNT_DIFF_PERCENT'] > 0){?>
						<span class="badge">
							-<?=$arResult['MIN_PRICE2']['DISCOUNT_DIFF_PERCENT']?>%
							<img src="/upload/img/badge-discount.png" alt="">
						</span>
					<?}?>
					<?if($arResult['ITEM_PRICES'][0]['PERCENT'] > 0){?>
						<span class="badge">
							-<?=$arResult['ITEM_PRICES'][0]['PERCENT']?>%
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
								<span class="lower_price_text">Возможно изготовление<br>по вашим размерам.</span>
								<img  src="/upload/img/rubl1.png" alt="Хотите цену ниже?">
							</div>
						<?}?>
			</div>
			<div class="gallery__preview js-gallery-preview">
				<a rel="" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="js-fancybox is-active"><img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt=""></a>
				<? foreach($arResult['PROPERTIES']['DET_PIC']['VALUE'] as $key => $pic){?>
					<a rel="gallery321" class="js-fancybox" href="<?=$arResult['PROPERTIES']['DET_PIC'][$pic]['REAL_SRC']?>"><img src="<?=$arResult['PROPERTIES']['DET_PIC'][$pic]['SRC']?>"  width="<?=$arResult['PROPERTIES']['DET_PIC'][$pic]['WIDTH']?>" height ="<?=$arResult['PROPERTIES']['DET_PIC'][$pic]['HEIGHT']?>"  alt=""></a>
				<?} 
				if(!empty($arResult['PROPERTIES']['VIDEO']['VALUE'])) { ?>
					<?foreach($arResult['PROPERTIES']['VIDEO']['~VALUE'] as $item){
						if(!preg_match("/v=(?<vid>[^\&]*)/",$item,$matches)) continue; 
					
					?>
					 	<a rel="gallery321" class="js-fancybox js-video" href="https://www.youtube.com/embed/<?=$matches['vid']?>?rel=0&showinfo=0" data-rel="media"><img src="https://img.youtube.com/vi/<?=$matches['vid']?>/0.jpg" alt="" class="video__prev"></a>
					 	
			<?	} } ?>
			</div>

		</div>
		<div class="prod" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <?
            $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $url = explode('?', $url);
            $url = $url[0];
            ?>
            <meta itemprop="url" content="<?echo $url;?>" />
            <meta itemprop="priceCurrency" content="RUB" />
            <meta itemprop="availability" content="https://schema.org/InStock">
			<?
			if(count($arResult['OFFERS']) <= 1){
				if((count($arResult['OFFERS']) == 1) || ($arResult['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET) ){?>
					<div class="prod__head">
						<div class="prod__meta">
							<?if(($arResult['OFFERS'][0]['PROPERTIES']['AVAILABLE']['VALUE'] == 'В наличии') || ($arResult['PROPERTIES']['AVAILABLE']['VALUE']  == 'В наличии')){?>
								<div class="prod__state is-available">В наличии</div>
							<?} else {?>
								<div class="prod__state is-order">Под заказ</div>
								<div class="prod__delivery"><?
										if($arResult['OFFERS'][0]['PROPERTIES']['POSTAVKA']['VALUE'])  echo $arResult['OFFERS'][0]['PROPERTIES']['POSTAVKA']['VALUE'];
											elseif($arResult['PROPERTIES']['POSTAVKA']['VALUE']) echo $arResult['PROPERTIES']['POSTAVKA']['VALUE'];
										?>
								</div>
							<?}?>
						</div>
					</div>
					<div class="prod__price">
						<?if($arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['DISCOUNT_DIFF_PERCENT'] > 0){?>
							<div class="old-price">
								Старая  цена: <span><?=$arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['PRINT_VALUE'];?></span>
							</div>
						<?}elseif($arResult['MIN_PRICE']['DISCOUNT_DIFF']){?>
							<div class="old-price">
								Старая  цена: <span><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></span>
							</div>
						<?}elseif($arResult['OFFERS'][0]['ITEM_PRICES'][0]['BASE_PRICE'] && $arResult['OFFERS'][0]['ITEM_PRICES'][0]['DISCOUNT'] > 0){?>
                            <div class="old-price">
                                Старая  цена: <span><?=$arResult['OFFERS'][0]['ITEM_PRICES'][0]['BASE_PRICE']?></span>
                            </div>
						<?}elseif($arResult['ITEM_PRICES'][0]['BASE_PRICE'] && $arResult['ITEM_PRICES'][0]['DISCOUNT'] > 0){?>
                            <div class="old-price">
                                Старая  цена: <span><?=$arResult['ITEM_PRICES'][0]['BASE_PRICE']?></span>
                            </div>
						<?}?>
                        <?
                        $itemPriceCurr = '';
                        if($arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE']) {
                            $itemPrice = $arResult['OFFERS'][0]['PRICES'][$_SESSION['region_price']]['PRINT_DISCOUNT_VALUE'];
                        } elseif($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']){
                            $itemPrice = $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                        } elseif($arResult['OFFERS'][0]['ITEM_PRICES'][0]['PRICE']){
                            $itemPrice = number_format($arResult['OFFERS'][0]['ITEM_PRICES'][0]['PRICE'], 0, '', ' ');
                            $itemPriceCurr = ' Р';
                        } else {
                            $itemPrice = number_format($arResult['ITEM_PRICES'][0]['PRICE'], 0, '', ' ');
                            $itemPriceCurr = ' Р';
                        }
                        ?>
						<div class="prod__sum"><?// 111 Наборы ?>
							<?=$itemPrice . $itemPriceCurr;?>
						</div>
                        <meta itemprop="price" content = "<?=str_replace(' ', '', $itemPrice)?>"/>

						
						<?
							if($arResult['OFFERS'][0]['ID'])
							{
								$ITEM_ID = $arResult['OFFERS'][0]['ID']; 
								$IBLOCK_ID = 2;
							}else{
								$ITEM_ID = $arResult['ID'];
								$IBLOCK_ID = 1;
							}
							?>
						<a id="ajaxaction=add&ajaxaddid=<?=$ITEM_ID ?>" href="#" class="addtobasket btn btn_green btn_basket">В корзину</a>

						  <div><a class="buy-click js-popup-link2" href="js-popup-buy" data-id="<?=$ITEM_ID?>" data-iblock-id="<?=$IBLOCK_ID?>">Быстро купить в 1 клик</a></div>  
		 <a  href="/rassrochka/"  class="rassrochka" >В рассрочку</a> 

					</div>
				<?} else {?>
					<div class="prod__head">
						<div class="prod__meta">
							<div class="prod__state is-order">Под заказ</div>
						</div>
					</div>
					<div class="prod__price">
						<a href="#" class="btn btn_green btn_basket" disabled>Уточняйте у менеджера</a>
					</div>
				<?}
			} else {
				 require_once($_SERVER["DOCUMENT_ROOT"]."/catalog/getSkuProd.php");
			}?>
		</div>
		
						<script>
							$(function(){
								$("body").on("click", ".js-popup-link2", function(event){
									$(".js-overlay").fadeOut(200);
									var popup = $(this).attr("href");
									if(popup == 'js-popup-buy'){
										var id = $(this).data("id");
										$('.js-popup-buy').find('.id_tovara').val(id);
										$('.js-popup-buy').find('.id_iblock').val( $(this).data("iblock-id") );
									}
									$("body").addClass("has-open-popup");
									$("."+popup).parent().fadeIn(200);
									event.stopPropagation();
									return false;
								});
							});
						</script>
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
				<a href="js-tab4"><span>Видео</span></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="js-tab-cont js-tab1">
				<ul class="prod-param prod-param_left">
					<?$k = 0;?>
					<?foreach($arResult['DISPLAY_PROPERTIES'] as $key => $prop){?>
                        <? if($prop['CODE'] == 'PRICE_LOWER') { continue; } ?>
						<?$k++;?>
						<li>
                            <?if($key == 'ARTNUMBER'){?>
                                <meta itemprop="sku" content = "<?=$prop['VALUE']?>">
                            <?}?>
							<?if($key == 'PR100'){?>
								<strong>Материал</strong>
							<?} else {?>
								<strong><?=$prop['NAME']?></strong>
							<?}?>
							<?if($key == 'MANUFACTURER'){?>
								<span><a href="<?=$arResult['MANUFACTURER']['SECTION_PAGE_URL']?>"><?=$prop['VALUE']?></a></span>
							<?}elseif($key == 'SERIES'){?>
								<span><a href="<?=$arResult['SERIES']['DETAIL_PAGE_URL']?>"><?=$prop['VALUE']?></a></span>
                                <meta itemprop="brand" content="<?=$prop['VALUE']?>" />
							<?} else {?>
								<?if(is_array($prop['VALUE'])){?>
									<span><?foreach($prop['VALUE'] as $v){echo $v.' ';}?></span>
								<?} else {?>
									<span><?=$prop['VALUE']?></span>
								<?}?>
							<?}?>
						</li>
						<?if((count($arResult['DISPLAY_PROPERTIES'])/2 < $k) && $n != 'y'){$n = 'y'; echo '</ul><ul class="prod-param prod-param_right">';}?>
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
				<?if(!empty($arResult['PROPERTIES']['VIDEO']['VALUE'])) { ?>
					<a rel="gallery321" class="js-fancybox js-video fancybox.iframe" href="https://www.youtube.com/embed/<?=$matches['vid']?>?rel=0&showinfo=0" data-rel="media"><img src="https://img.youtube.com/vi/<?=$matches['vid']?>/0.jpg" alt="" class="video__prev"></a>
			<?}?>
			</div>
			 
		</div>


		<div class="social social-likes" style="margin: 20px 0 0; width: 100%;">
			<div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
			<div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
			<div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
		</div>
        <?
if(count($arResult['SET'])):
        global $arFilterSet;
        $arFilterSet = Array("ID" =>$arResult['SET']);

            ?>
            <div class="titleSeria">Товары комплекта:</div>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "seria",
                array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "1",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_NAME" => 'arFilterSet',
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "PAGE_ELEMENT_COUNT" => "999",
                    "LINE_ELEMENT_COUNT" => "3",
                    "PROPERTY_CODE" => array(
                        0 => "PR100",
                        1 => "NEWPRODUCT",
                        2 => "",
                    ),
                    "OFFERS_FIELD_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_PROPERTY_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "OFFERS_LIMIT" => "0",
                    "TEMPLATE_THEME" => "blue",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "ADD_PICT_PROP" => "-",
                    "LABEL_PROP" => "-",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "META_KEYWORDS" => "-",
                    "SET_META_DESCRIPTION" => "Y",
                    "META_DESCRIPTION" => "-",
                    "BROWSER_TITLE" => "-",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "SET_TITLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "CACHE_FILTER" => "N",
                    "PRICE_CODE" => array('RUB'),
                    "USE_PRICE_COUNT" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "BASKET_URL" => "/personal/basket.php",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRODUCT_PROPERTIES" => array(),
                    "OFFERS_CART_PROPERTIES" => array(),
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity"
                ),
                false
            );
 endif;

        $IDS = array();
        $arSelect = Array();
        $arFilter = Array("IBLOCK_ID"=>1, "PROPERTY_30_VALUE" => $arResult['PROPERTIES']['SERIES']['VALUE']);
        $res = CIBlockElement::GetList(array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            if( $arFields['ID'] == $arResult['ID']) continue;
            $arProperties = $ob->GetProperties();
            $IDS[] = $arFields['ID'];
        }
        $IDS = array_diff($IDS, $arResult['SET']);
        global $arFilterS;
        $arFilterS = Array("ID" => $IDS);
        if(count($IDS) > 1) {
            ?>
            <div class="titleSeria">Другие товары этой серии:</div>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "seria",
                array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "1",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_NAME" => 'arFilterS',
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "PAGE_ELEMENT_COUNT" => "999",
                    "LINE_ELEMENT_COUNT" => "3",
                    "PROPERTY_CODE" => array(
                        0 => "PR100",
                        1 => "NEWPRODUCT",
                        2 => "",
                    ),
                    "OFFERS_FIELD_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_PROPERTY_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "OFFERS_LIMIT" => "0",
                    "TEMPLATE_THEME" => "blue",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "ADD_PICT_PROP" => "-",
                    "LABEL_PROP" => "-",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "META_KEYWORDS" => "-",
                    "SET_META_DESCRIPTION" => "Y",
                    "META_DESCRIPTION" => "-",
                    "BROWSER_TITLE" => "-",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "SET_TITLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "CACHE_FILTER" => "N",
                    "PRICE_CODE" => array('RUB'),
                    "USE_PRICE_COUNT" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "BASKET_URL" => "/personal/basket.php",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRODUCT_PROPERTIES" => array(),
                    "OFFERS_CART_PROPERTIES" => array(),
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity"
                ),
                false
            );
        }
        ?>


	</div>
	<div class="l-col2">
		<div class="add-info">
			<div class="add-info__head">
				<div class="add-info__delivery">
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

<div class="catalog-back"><a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" class="link-prev is-orange">Назад в каталог</a></div>

