<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); 
?>

<div class="h2 text-center">
                        Новости
                    </div>
                    <div class="news__grid">
                    		<?foreach($arResult["ITEMS"] as $arItem){?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
                        <div class="news-card">
                            <div class="news-card__date">
                                <?=$arItem['DISPLAY_ACTIVE_FROM']?>
                            </div>
                            <div class="news-card__title">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="post__title"><?=$arItem['NAME']?></a>
                            </div>
                            <div class="news-card__text">
                                <?=$arItem['PREVIEW_TEXT']?>
                            </div>
                        </div>
                        <?}?>
                    </div>
                    <div class="news__nav">
                        <a href="/blog/news/" class="news__link">Все новости</a>
                    </div>