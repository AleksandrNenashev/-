<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="partners m-section">
                <div class="container _type2">
                    <div class="partners-slider slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?foreach($arResult["SECTIONS"] as $arSection){?>
									<?
									$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
									$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
									$strMainID = $this->GetEditAreaId($arSection['ID']);
									?>
                                <div class="swiper-slide">
                                	<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="partner-card">
                                		<img src="<?=$arSection['PICTURE']['SRC']?>" alt="<?=$arSection['NAME']?>">
                                	</a>
                                </div>
                                <?}?>
                            </div>
                        </div>
                        <div class="swiper-nav">
                            <div class="swiper-button swiper-button-prev">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/prev.png" alt="">
                            </div>
                            <div class="swiper-button swiper-button-next">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/next.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
</div>