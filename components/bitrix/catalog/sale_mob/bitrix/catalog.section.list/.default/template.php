<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//$this->createFrame()->begin('Загрузка....');
$this->setFrameMode(true);
?><?
global $sect_id;
$sect_id = $arResult['SECTION']['ID'];
global $sidebar_menu;
$sidebar_menu['SELECTED']['TEXT'] = $arResult['SECTION']['NAME'];
//$i = count($arResult['SECTION']['PATH']) - 2;
//$sidebar_menu['BACKLINK']['LINK'] = $arResult['SECTION']['PATH'][$i]['SECTION_PAGE_URL'];
//$sidebar_menu['BACKLINK']['TEXT'] = $arResult['SECTION']['PATH'][$i]['NAME'];
?>

<?if(!empty($arResult['SECTIONS'])){?>
	<?
	global $titleText;
	$titleText = $arResult['SECTION']['DESCRIPTION'];

	function AfterTitleText(){
		global $titleText;
		return $titleText;
	}
	?>


	<?foreach ($arResult['SECTIONS'] as $arSection)
	{
		$cur['LINK'] = $arSection['SECTION_PAGE_URL'];
		$cur['TEXT'] = $arSection['NAME'];
		$sidebar_menu['RESULT'][] = $cur;
		
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		$strMainID = $this->GetEditAreaId($arSection['ID']);
		?>
		<div class="items-row" id="<? echo $strMainID; ?>">
			<div class="items-row__top">
				<div class="items-row__title">
					<a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
					<?if(!empty($arSection['UF_TOVAROV'])){?><span><?=$arSection['UF_TOVAROV']?> товаров</span><?}?>
				</div>
				<a class="items-row__all" href="<?=$arSection['SECTION_PAGE_URL']?>">Все товары</a>
			</div>
				<div class="item-wood">
			<?foreach ($arSection['ELEMENTS'] as $arItem)
			{
				?>
				<div class="item item_round">
					<div class="badge-wrap">
						<?if($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == 'Да'){?>
							<span class="badge">
								new
								<img src="/upload/img/badge-new.png" alt="">
							</span>
						<?}?>
						<?if($arItem['PRICES']['RUB']['DISCOUNT_DIFF_PERCENT'] > 0){?>
							<span class="badge">
								-<?=$arItem['PRICES']['RUB']['DISCOUNT_DIFF_PERCENT']?>%
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
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE_SRC']?>" alt=""></a>
						</div>
						<div class="item__main">
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="prod-title"><?=$arItem['NAME']?></a>

							<div class="price"><?=$arItem['PRICES']['RUB']['PRINT_DISCOUNT_VALUE']?></div>
							<?if($arItem['PRICES']['RUB']['DISCOUNT_DIFF_PERCENT'] > 0){?><div class="old-price"><span><?=$arItem['PRICES']['RUB']['PRINT_VALUE_NOVAT']?></span></div><?}?>

							<?if(!empty($arItem['PRICES']['RUB']['PROPERTIES']['SIZE']['VALUE'])){?><div class="item__size"><?=$arItem['PRICES']['RUB']['PROPERTIES']['SIZE']['VALUE']?> см</div><?}?>
							<!--<a id="ajaxaction=add&ajaxaddid=<?=$prices[$arItem['ID']]['ID']?>" href="" class="addtobasket btn btn_green">Купить</a>-->
							<?if(!empty($arItem['PRICES']['RUB']['ONE'])){?>
								<a class="addtobasket btn btn_green" href="#" id="ajaxaction=add&amp;ajaxaddid=<?=$arItem['PRICES']['RUB']['ONE']?>">В корзину</a>
							<?}?>
						</div>
					</div>
				</div>
			<?}?>
			</div>
		</div>
	<?}?>
	<?//echo '<pre style="display:block;">'; print_r($arResult['SECTIONS']); echo '</pre>';?>
<?} else {
	global $sect_empty;
	$sect_empty = true;
}?>
<?//echo '<pre style="display:block;">'; print_r($arResult); echo '</pre>';?>