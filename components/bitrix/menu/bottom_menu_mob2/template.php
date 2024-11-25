<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if (!empty($arResult)):?>
<div class="footer-nav__title">
    О магазине
</div>

<div class="footer-nav__links">
    <div class="footer-nav__links-group">
        <?foreach($arResult as $key => $arItem):
        $left = ceil(count($arResult)/2);
        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
            continue;
        ?>
            <?if($arItem["SELECTED"]):?>
                <a href="<?=$arItem["LINK"]?>" class="footer-nav__link selected"><?=$arItem["TEXT"]?></a>
            <?else:?>
                <a href="<?=$arItem["LINK"]?>" class="footer-nav__link"><?=$arItem["TEXT"]?></a>
            <?endif?>
            <?if($key+1 == $left){?></div><div class="footer-nav__links-group"><?}?>
        <?endforeach?>
    </div>
</div>
<?endif?>
