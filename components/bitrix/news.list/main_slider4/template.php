<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="main">
                <div class="container">
                    <div class="main-slider slider">
                        <div class="swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <?
                                                                                        foreach($arResult["ITEMS"] as $arItem)
                                                                                        {
                                                                                            //echo "<pre>";print_r($arItem);echo "</pre>";
                                                                                            ?>
                                                        <div class="swiper-slide">
                                                            <a href="<?=$arItem['PROPERTIES']['link']['VALUE']?>" class="main-slider__img">
                                                                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                                                            </a>
                                                        </div>
                                                        <?}?>
                                                    </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>        
</div>