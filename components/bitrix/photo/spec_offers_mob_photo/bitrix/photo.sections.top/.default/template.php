<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="offer2 m-section _tabs-parent">
    <div class="container">
        <div class="h2 text-center">
            Спецпредложения
        </div>
        <div class="offer2__tabs">
            <?foreach ($arResult["SECTIONS"] as $index => $arSection):?>
                <div class="offer2__tab _tab<?= $index === 0 ? ' _active' : '' ?>" data-tab="_tab<?= $arSection['ID'] ?>">
                    <span><?= $arSection["NAME"] ?></span>
                </div>
            <?endforeach;?>
        </div>

        <?foreach ($arResult["SECTIONS"] as $index => $arSection):?>
            <div class="tab-content _tab<?= $arSection['ID'] ?><?= $index === 0 ? ' _active' : '' ?>">
                <div class="offer-slider slider">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?foreach ($arSection["ITEMS"] as $arItem):?>
                                <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                                    <a href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>" class="offer-slider__img">
                                        <img 
                                            src="<?= $arItem["PICTURE"]["SRC"] ?>" 
                                            alt="<?= $arItem["PICTURE"]["ALT"] ?>" 
                                            title="<?= $arItem["PICTURE"]["TITLE"] ?>"
                                            width="<?= $arItem["PICTURE"]["WIDTH"] ?>" 
                                            height="<?= $arItem["PICTURE"]["HEIGHT"] ?>">
                                    </a>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
