<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?require_once($_SERVER["DOCUMENT_ROOT"].'/includes/getPrice.php')?>
<?
foreach($arResult['ITEMS'] as $arItem){
	$ids[] = $arItem['ID'];
}

$prices = getPrise($ids);


foreach($arResult['ITEMS'] as &$arItem){
	$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>'215', 'height'=>170), BX_RESIZE_IMAGE_PROPORTIONAL, false);
	$arItem['PREVIEW_PICTURE']['RESIZE_SRC'] = $file['src'];
	if(!empty($prices[$arItem['ID']])){
		$arItem['PRICES'][$_SESSION['region_price']] = $prices[$arItem['ID']];
	}
}

?>
