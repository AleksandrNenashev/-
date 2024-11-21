<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//echo '<pre style="display:block;">'; print_r($arResult); echo '</pre>';?>
<?
if(!empty($arResult["CATEGORIES"])){?>
<table class="title-search-result">
	<div class="search-drop title-search-result" style="display:block">
		<ul class="list-item-wrap">
			<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory){?>
				<?foreach($arCategory["ITEMS"] as $i => $arItem){?>
					<?if($arItem['ITEM_ID'][0] == 'S' && $arItem['NAME'] != 'остальные'){?>
						<li class="list-categ">
							<div class="list-categ__name">
								<a href="<?=$arItem['URL']?>"><?=$arItem['NAME']?></a>
							</div>
						</li>
					<?}?>
				<?}?>
				<?foreach($arCategory["ITEMS"] as $i => $arItem){?>
					<?if($arItem['ITEM_ID'][0] != 'S' && $arItem['NAME'] != 'остальные'){?>
						<?$res = CIBlockElement::GetByID($arItem['ITEM_ID']);
						if($ar_res = $res->GetNext()){
							$pic = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
						}?>
						<li class="list-item">
							<div class="list-item__img">
								<a href="<?=$arItem['URL']?>"><img src="<?=$pic?>" alt="" width="63"></a>
							</div>
							<div class="list-item__info">
								<a href="<?=$arItem['URL']?>"><?=$arItem['NAME']?></a>
								<?if(!empty($arItem['PRICES']['RUB']['PROPERTIES']['SIZE']['VALUE'])){?><span><?=$arItem['PRICES']['RUB']['PROPERTIES']['SIZE']['VALUE']?> СМ</span><?}?>
							</div>
							<div class="list-item__price">
								<div class="price"><?=$arItem['PRICES']['RUB']['PRINT_DISCOUNT_VALUE']?></div>
								<?if($arItem['PRICES']['RUB']['DISCOUNT_DIFF_PERCENT'] > 0){?><div class="old-price"><span><?=$arItem['PRICES']['RUB']['PRINT_VALUE_NOVAT']?></span></div><?}?>
							</div>
						</li>
					<?}?>
				<?}?>
			<?}?>
		</ul>
	</div>
</table>
<?}?>

