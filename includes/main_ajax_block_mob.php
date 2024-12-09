<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Логирование запросов для отладки (можно удалить после проверки)
// file_put_contents($_SERVER['DOCUMENT_ROOT'].'/ajax_debug.log', print_r($_POST, true), FILE_APPEND);

// Обработка AJAX-запросов
if (!empty($_POST['action'])) {
    $action = $_POST['action'];

    // Подключаем модули
    if (!CModule::IncludeModule('sale') || !CModule::IncludeModule('catalog')) {
        echo json_encode(['status' => 'error', 'message' => 'Не удалось подключить модули']);
        exit;
    }

    switch ($action) {
        case 'add':
            if (!empty($_POST['addId'])) {
                $productId = (int)$_POST['addId'];
                $quantity = 1; // Количество товара, можно изменить на основе запроса

                // Добавление товара в корзину
                $result = Add2BasketByProductID($productId, $quantity);
                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Товар добавлен в корзину', 'basket_id' => $result]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Ошибка добавления товара']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Не указан ID товара']);
            }
            break;

        case 'remove':
            // Пример обработки удаления товара (если понадобится)
            echo json_encode(['status' => 'error', 'message' => 'Удаление товара пока не реализовано']);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Неизвестное действие']);
            break;
    }
    exit;
}

// Фильтрация и вывод товаров (как в оригинальном коде)
if (empty($_POST)) {
    $arFilPop = ["PROPERTY_TOP_INDEX_VALUE" => "Да"];
} else {
    switch ($_POST['tab']) {
        case 'pop':
            $arFilPop = ["PROPERTY_TOP_INDEX_VALUE" => "Да"];
            break;

        case 'sale':
            $obCache = new CPHPCache();
            if ($obCache->InitCache(36000, 'sale', "/iblock/catalog")) {
                $arFilPop = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                CModule::IncludeModule("catalog");
                $dbProductDiscounts = CCatalogDiscount::GetList(
                    ["SORT" => "ASC"],
                    [
                        "ACTIVE" => "Y",
                        "!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", CSite::GetDateFormat("FULL")),
                        "!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", CSite::GetDateFormat("FULL")),
                        "COUPON" => ""
                    ],
                    false,
                    false,
                    []
                );
                while ($arProductDiscounts = $dbProductDiscounts->Fetch()) {
                    $sku_id[] = $arProductDiscounts['PRODUCT_ID'];
                }

                if (!empty($sku_id)) {
                    $arSelect = ["ID", "NAME", "PROPERTY_CML2_LINK"];
                    $arFilter = ["IBLOCK_ID" => 2, "ACTIVE" => "Y", "ID" => $sku_id];
                    $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, false, $arSelect);
                    while ($ob = $res->GetNextElement()) {
                        $arFields = $ob->GetFields();
                        $ids[] = $arFields['PROPERTY_CML2_LINK_VALUE'];
                    }
                }
                $arFilPop = !empty($ids) ? ["ID" => $ids] : ["ID" => 0];
                $obCache->EndDataCache($arFilPop);
            }
            break;

        case 'new':
            $arFilPop = ["PROPERTY_NEWPRODUCT_VALUE" => "Да"];
            break;

        default:
            $arFilPop = [];
            break;
    }
}

// Включение компонента для вывода товаров
$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "main_scroller",
    [
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "1",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => [],
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "arFilPop",
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "Y",
        "HIDE_NOT_AVAILABLE" => "N",
        "PAGE_ELEMENT_COUNT" => "36",
        "LINE_ELEMENT_COUNT" => "4",
        "PROPERTY_CODE" => ["PR100", "NEWPRODUCT"],
        "OFFERS_FIELD_CODE" => [],
        "OFFERS_PROPERTY_CODE" => [],
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER2" => "desc",
        "OFFERS_LIMIT" => "5",
        "TEMPLATE_THEME" => "blue",
        "PRODUCT_DISPLAY_MODE" => "N",
        "ADD_PICT_PROP" => "-",
        "LABEL_PROP" => "-",
        "PRODUCT_SUBSCRIPTION" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "META_KEYWORDS" => "-",
        "SET_META_DESCRIPTION" => "Y",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "ADD_SECTIONS_CHAIN" => "N",
        "DISPLAY_COMPARE" => "N",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "N",
        "CACHE_FILTER" => "N",
        "PRICE_CODE" => [],
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "CONVERT_CURRENCY" => "N",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "USE_PRODUCT_QUANTITY" => "N",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRODUCT_PROPERTIES" => [],
        "OFFERS_CART_PROPERTIES" => [],
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => "",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity"
    ],
    false
);
?>
