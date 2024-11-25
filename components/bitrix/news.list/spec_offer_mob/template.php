<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateFolder */
$this->setFrameMode(true);
?>

<div class="offer2 m-section _tabs-parent">
    <div class="container">
        <div class="h2 text-center">
            Спецпредложения
        </div>

        <div class="offer2__tabs">
            <?php $tabCounter = 1; ?>
            <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                <div class="offer2__tab _tab <?= $tabCounter === 1 ? '_active' : '' ?>" data-tab="_tab<?= $tabCounter ?>">
                    <span><?= $arItem["NAME"] ?></span>
                </div>
                <?php $tabCounter++; ?>
            <?php endforeach; ?>
        </div>

        <?php $tabCounter = 1; ?>
        <?php foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="tab-content _tab<?= $tabCounter ?> <?= $tabCounter === 1 ? '_active' : '' ?>">
                <div class="offer-slider slider">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <!-- Проверяем и выводим 2 картинки для каждого таба -->
                            <?php if (!empty($arItem["PROPERTIES"]["DETAIL_PICTURE_1"]["VALUE"])): ?>
                                <div class="swiper-slide">
                                    <a href="" class="offer-slider__img">
                                        <img src="<?= CFile::GetPath($arItem["PROPERTIES"]["DETAIL_PICTURE_1"]["VALUE"]) ?>" alt="">
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($arItem["PROPERTIES"]["DETAIL_PICTURE_2"]["VALUE"])): ?>
                                <div class="swiper-slide">
                                    <a href="" class="offer-slider__img">
                                        <img src="<?= CFile::GetPath($arItem["PROPERTIES"]["DETAIL_PICTURE_2"]["VALUE"]) ?>" alt="">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <?php $tabCounter++; ?>
        <?php endforeach; ?>

    </div>
</div>
