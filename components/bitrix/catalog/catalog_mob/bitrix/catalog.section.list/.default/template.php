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

<?
if(!empty($arResult['SECTIONS'])){?>
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

        <div class="sales m-section">
                <div class="container _type2">
                    <div class="h2 text-center">
                        распродажа
                    </div>
                    <div class="sales-slider slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
							<?foreach ($arSection['ELEMENTS'] as $arItem)
			                   {
				                ?>
                                <div class="swiper-slide">
                                    <div class="product-card">

                                        <div class="product-card__badges">

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/new.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/sale.png" alt="">
                                            </div>

                                            <div class="product-card__badge">
                                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/eco.png" alt="">
                                            </div>
                                        </div>

										<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="product-card__img"><img src="<?=$arItem['PREVIEW_PICTURE_SRC']?>" alt=""></a>
                                        <div class="product-card__title"> 
                                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="text21 text14-mob"><?=$arItem['NAME']?></a>
                                        </div>
                                        <div class="product-card__prices">
                                            <div class="product-card__price">
												<?=$arItem['PRICES']['RUB']['PRINT_DISCOUNT_VALUE']?>
                                            </div>
                                            <div class="product-card__price2">
                                                74 490 Р
												<?=$arItem['PRICES']['RUB']['PRINT_VALUE_NOVAT']?>
                                            </div>
											<?if(!empty($arItem['PRICES']['RUB']['ONE'])){?>
												<a class="addtobasket btn btn_green" href="#" id="ajaxaction=add&amp;ajaxaddid=<?=$arItem['PRICES']['RUB']['ONE']?>">В корзину</a>
											<?}?>
                                        </div>
                                    </div>
                                </div>
                                <?}?>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>



	<?}?>
	<?//echo '<pre style="display:block;">'; print_r($arResult['SECTIONS']); echo '</pre>';?>
<?} else {
	global $sect_empty;
	$sect_empty = true;
}?>
<?//echo '<pre style="display:block;">'; print_r($arResult); echo '</pre>';?>