<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="offer">
<div class="container">
                    <div class="offer__grid">
                            	<?
								foreach($arResult["ITEMS"] as $arItem)
								{
								//echo "<pre>";print_r($arItem);echo "</pre>";
								?>
                                <a href="<?=$arItem['PROPERTIES']['link']['VALUE']?>" class="offer-card">
                                    <div class="offer-card__img">
                                        <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                                    </div>
                                    <div class="offer-card__badge">
                                        <div class="text16 text13-mob">
                                            <?=$arItem["NAME"]?>
                                        </div>
                                    </div>
                                </a>
                                <?
								}
								?>
                                <a href="/catalog/" class="offer-link">
                                    <div class="offer-link__inner">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/img/eye.svg" alt="" class="offer-link__img">
                                        <div class="offer-link__text">
                                            Смотреть все  уникальные
                                            предложения
                                        </div>
                                    </div>
                                </a>
                    </div>
</div>
</div>