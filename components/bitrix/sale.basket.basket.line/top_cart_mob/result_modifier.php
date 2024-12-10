<?php
$arResult["QUANTITY"] = [];
foreach ($arResult["CATEGORIES"]["READY"] as $arItem){
    $id = $arItem["PRODUCT_ID"];
    if(strpos($arItem["PRODUCT_XML_ID"], '#')){
        $arProduct = \CCatalogSku::GetProductInfo($arItem["PRODUCT_ID"]);
        $id = $arProduct["ID"];
        $arItem["PRODUCT_PARENT_ID"] = $id;
    }

    $arResult["QUANTITY"][$id] += $arItem["QUANTITY"];
}
