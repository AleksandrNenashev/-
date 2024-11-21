<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?
$APPLICATION->AddHeadScript("/includes/slider/jquery.jcarousel.min.js");
?>
<div class="jcarousel" style="width: 475px;">
  <ul><?
	foreach($arResult["ITEMS"] as $arItem)
	{
		//echo "<pre>";print_r($arItem);echo "</pre>";
		?><li>
			<a href="<?=$arItem['PROPERTIES']['link']['VALUE']?>">
				<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="475" height="325"  />
			</a>
		</li><?
	}
	?></ul>
  <?/*<a href="#" class="jcarousel-control-prev" >&lsaquo;</a>
  <a href="#" class="jcarousel-control-next" >&rsaquo;</a> */?>
  <p class="jcarousel-pagination2"></p>
</div>