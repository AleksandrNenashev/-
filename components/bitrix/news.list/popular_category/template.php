<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="categories m-section">
                <div class="container">
                
                    <div class="h2 text-center">
                        Популярные категории
                    </div>
                    <div class="categories__grid">
                        <?
                        foreach($arResult["ITEMS"] as $arItem)
                        {      
                        ?>
                        <a href="<?=$arItem['PROPERTIES']['link']['VALUE']?>" class="category-card">
                            <div class="category-card__img">
                                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                            </div>
                            <div class="category-card__title text21 text11-mob">
                                <?=$arItem["NAME"]?>
                            </div>
                        </a>
                        <?
                        }
                        ?>
                    </div>
                    
                </div>
</div>