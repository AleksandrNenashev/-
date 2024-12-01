<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?

// Массив для сохранения данных товаров
$featuredItems = [];

function url($cut){
	global $APPLICATION;
	$url = $APPLICATION->GetCurDir().'?';
	foreach($_GET as $k => $g){
		if(empty($cut)){
			if($k != 'sort' && $k != 'order'){
				$url .= $k.'='.$g.'&';
			}
		} else {
			if($k != $cut){
				$url .= $k.'='.$g.'&';
			}
		}
	}
	return $url;
}
$name_order = 'asc';
$price_order = 'asc';
$new_order = 'asc';

$name_link = url('').'sort=name&order='.$name_order;
$price_link = url('').'sort=price&order='.$price_order;
$new_link = url('').'sort=new&order='.$new_order;

switch ($_GET['sort']) {
case 'name':
	if($_GET['order'] == 'asc'){
		$act_name = 'is-top-sort';
		$name_order = 'desc';
	} else {
		$act_name = 'is-down-sort';
		$name_order = 'asc';
	}
	break;
case 'price':
	if($_GET['order'] == 'asc'){
		$act_price = 'is-top-sort';
		$price_order = 'desc';
	} else {
		$act_price = 'is-down-sort';
		$price_order = 'asc';
	}
	break;
case 'new':
	if($_GET['order'] == 'asc'){
		$act_new = 'is-top-sort';
		$new_order = 'desc';
	} else {
		$act_new = 'is-down-sort';
		$new_order = 'asc';
	}
	break;
}
?>
<?
// Сбор данных товаров
             foreach($arResult['ITEMS'] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
			$strMainID = $this->GetEditAreaId($arItem['ID']);
			?>
            <?$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = $arItem['OFFERS'][0]['ITEM_PRICES'][0]['RATIO_PRICE'];?>
            <?foreach ($arItem['OFFERS'] as $keyOffer => $arOffer){
            if ($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] > $arOffer['ITEM_PRICES'][0]['RATIO_PRICE']){
                $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = $arOffer['ITEM_PRICES'][0]['RATIO_PRICE'];
                $arItem['MIN_PRICE']['OFFER_ID_PRICE'] = $keyOffer;
            }
        }
            $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = $arItem['OFFERS'][$keyOffer]['ITEM_PRICES'][0]['PERCENT'];
            $arItem['MIN_PRICE']['PRINT_VALUE'] = $arItem['OFFERS'][$keyOffer]['ITEM_PRICES'][0]['RATIO_BASE_PRICE'];

            $priceItem = $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
            $oldPriceItem = $arItem['MIN_PRICE']['PRINT_VALUE'];
            $percent = $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
            if ($priceItem == 0){
                $priceItem = $arItem['ITEM_PRICES'][0]['RATIO_PRICE'];
            }
            if (!$oldPriceItem){
                $oldPriceItem = $arItem['ITEM_PRICES'][0]['BASE_PRICE'];
            }
            if (!$percent){
                $percent = $arItem['ITEM_PRICES'][0]['PERCENT'];
            }
            ?>
<?
    // Сохраняем данные товара в массив
    $featuredItems[] = [
        'ID' => $arItem['ID'],
        'NAME' => $arItem['NAME'],
        'URL' => $arItem['DETAIL_PAGE_URL'],
        'IMAGE' => CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], ['width' => '215', 'height' => '170'], BX_RESIZE_IMAGE_PROPORTIONAL, false)['src'],
        'PRICE' => $priceItem,
        'OLD_PRICE' => $oldPriceItem,
        'DISCOUNT_PERCENT' => $percent,
        'PROPERTIES' => $arItem['PROPERTIES'],
    ];
}

// Сохраняем массив товаров в опцию
if (!empty($featuredItems)) {
    COption::SetOptionString("main", "featured_items", serialize($featuredItems));
}

$name_link = url('').'sort=name&order='.$name_order;
$price_link = url('').'sort=price&order='.$price_order;
$new_link = url('').'sort=new&order='.$new_order;

global $sect_empty;
if($sect_empty){
?>
<?
global $showfilter;
$showfilter = 'y';
?>
	<div class="sort">
		<div class="sort__item">
			<div class="sort__title">Сортировать:</div>
			<a href="<?=$name_link?>" class="sort__key <?=$act_name?>"><span>название</span></a>
			<a href="<?=$price_link?>" class="sort__key <?=$act_price?>"><span>цена</span></a>
			<a href="<?=$new_link?>" class="sort__key <?=$act_new?>"><span>новинки</span></a>
		</div>
		<?/* */?>
		<div class="sort__item">
			<div class="sort__title">Товаров на странице:</div>
			<div class="select">
				<select id="js-count">
					<?
					$arCount = array('36', '72', '108');
					foreach($arCount as $c){?>
						<option <?if($c == $_GET['count']){echo 'selected';}?> value="<?=$c?>"><?=$c?></option>
					<?}?>
				</select>
			</div>
		</div>
		
		<div class="sort__item">
			<?if ($arParams["DISPLAY_TOP_PAGER"]){
				echo $arResult["NAV_STRING"];
			}?>
		</div>
	</div>
	<div class="items-row">
		<?foreach($arResult['ITEMS'] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
			$strMainID = $this->GetEditAreaId($arItem['ID']);
			?>
            <?$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = $arItem['OFFERS'][0]['ITEM_PRICES'][0]['RATIO_PRICE'];?>
            <?foreach ($arItem['OFFERS'] as $keyOffer => $arOffer){
            if ($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] > $arOffer['ITEM_PRICES'][0]['RATIO_PRICE']){
                $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = $arOffer['ITEM_PRICES'][0]['RATIO_PRICE'];
                $arItem['MIN_PRICE']['OFFER_ID_PRICE'] = $keyOffer;
            }
        }
            $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = $arItem['OFFERS'][$keyOffer]['ITEM_PRICES'][0]['PERCENT'];
            $arItem['MIN_PRICE']['PRINT_VALUE'] = $arItem['OFFERS'][$keyOffer]['ITEM_PRICES'][0]['RATIO_BASE_PRICE'];

            $priceItem = $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
            $oldPriceItem = $arItem['MIN_PRICE']['PRINT_VALUE'];
            $percent = $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
            if ($priceItem == 0){
                $priceItem = $arItem['ITEM_PRICES'][0]['RATIO_PRICE'];
            }
            if (!$oldPriceItem){
                $oldPriceItem = $arItem['ITEM_PRICES'][0]['BASE_PRICE'];
            }
            if (!$percent){
                $percent = $arItem['ITEM_PRICES'][0]['PERCENT'];
            }
            ?>
			<div class="item item_round" id="<? echo $strMainID; ?>">
				<div class="badge-wrap">
					<?if($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'){?>
						<span class="badge">
							new
							<img src="/upload/img/badge-new.png" alt="">
						</span>
					<?}?>
					 
					<?if($percent > 0){?>
						<span class="badge">
							-<?=$percent?>%
							<img src="/upload/img/badge-discount.png" alt="">
						</span>
					<?}?>
					<?if(!empty($arItem['PROPERTIES']['PR100']['VALUE'])){?>
						<span class="badge js-tooltip-key" data-title="100% <?=$prices[$arItem['ID']]['PROPERTIES']['PR100']['VALUE']?>">
							<img src="/upload/img/badge-eco.png" alt="">
						</span>
					<?}?>
				</div>
				 <?if($arItem['PROPERTIES']['PRICE_LOWER']['VALUE'] == 'да'){?>
							<div class="lower_price">
								<span class="lower_price_text">Возможно изготовление<br>по вашим размерам.</span>
								<img  src="/upload/img/rubl1.png" alt="Возможно изготовление по вашим размерам.">
							</div>
						<?}?>
				<div class="item__in">
					<div class="item__img">
<?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'215', 'height'=>170), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$file['src']?>" alt=""></a>
					</div>
					<div class="item__main">
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="prod-title"><?=$arItem['NAME']?></a>

						<div class="price"><?=number_format($priceItem, 0, ',', ' ');?> Р</div>
						<?if($percent > 0){?><div class="old-price"><span><?=number_format($oldPriceItem, 0, ',', ' ');?></span> Р</div><?}?>
						<?if(!empty($arItem['OFFERS'][0]['PROPERTIES']['SIZE']['VALUE'])){?><div class="item__size"><?=$arItem['OFFERS'][0]['PROPERTIES']['SIZE']['VALUE']?> см</div><?}?>
						<?if((count($arItem['OFFERS']) == 1) || ($arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET) ){?>
						<?if(is_array($arItem['OFFERS']) && $arItem['OFFERS'][0]['ID']) $ITEM_ID = $arItem['OFFERS'][0]['ID'];
							else $ITEM_ID = $arItem['ID'];?>
							<a class="addtobasket btn btn_green" href="#" id="ajaxaction=add&amp;ajaxaddid=<?=$ITEM_ID?>">В корзину</a>
						<?}?>
					</div>
				</div>
			</div>
		<?}?>
	</div>
	<?if ($arParams["DISPLAY_BOTTOM_PAGER"]){
		echo $arResult["NAV_STRING"];
	}?>
	<div class="article">
		<?=$arResult['DESCRIPTION']?>
	</div>
	<script>
	$(document).ready(function(){
		$('#js-count').on('change', function(){
			var count = $(this).val();
			document.location.href = '<?=url('count')?>' + 'count=' + count;
		});
	});
	</script>
<?}?>