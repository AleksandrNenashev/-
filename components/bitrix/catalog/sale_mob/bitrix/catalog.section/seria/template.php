<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?
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

	<div class="items-row">
		<?foreach($arResult['ITEMS'] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
			$strMainID = $this->GetEditAreaId($arItem['ID']);
			?>
			<div class="item item_round" id="<? echo $strMainID; ?>">
				<div class="badge-wrap">
					<?if($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'){?>
						<span class="badge">
							new
							<img src="/upload/img/badge-new.png" alt="">
						</span>
					<?}?>
					 
					<?if($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0){?>
						<span class="badge">
							-<?=$arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%
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
								<img  src="/upload/img/rubl1.png" alt="Хотите цену ниже?">
							</div>
						<?}?>
				<div class="item__in">
					<div class="item__img">
						<?//echo '<pre style="display:none;">'; print_r($arItem['PREVIEW_PICTURE']); echo '</pre>';?>
<?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'215', 'height'=>170), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$file['src']?>" alt=""></a>
					</div>
					<div class="item__main">
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="prod-title"><?=$arItem['NAME']?></a>
						<div class="price"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
						<?if($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0){?><div class="old-price"><span><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span></div><?}?>
						<?if(!empty($arItem['OFFERS'][0]['PROPERTIES']['SIZE']['VALUE'])){?><div class="item__size"><?=$arItem['OFFERS'][0]['PROPERTIES']['SIZE']['VALUE']?> см</div><?}?>
						<!--<a id="ajaxaction=add&ajaxaddid=<?=$prices[$arItem['ID']]['ID']?>" href="" class="addtobasket btn btn_green">Купить</a>-->
						<?if(count($arItem['OFFERS']) == 1){?>
							<a class="addtobasket btn btn_green" href="#" id="ajaxaction=add&amp;ajaxaddid=<?=$arItem['OFFERS'][0]['ID']?>">В корзину</a>
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