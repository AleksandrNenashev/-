<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?if (!empty($arResult)):?>
<div class="footer-top__links">

<?
foreach($arResult as $key => $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<a class="footer-top__link" href="<?=$arItem["LINK"]?>"><?if($key == 0){?><img src="<?= SITE_TEMPLATE_PATH ?>/img/marker.png" alt=""><?}?><span><?=$arItem["TEXT"]?></span></a>
	
<?endforeach?>

</div>
<?endif?>
