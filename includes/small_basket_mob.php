<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;

Loader::includeModule("sale");
Loader::includeModule("catalog");

header('Content-Type: application/json');

// Получение первого доступного предложения
function getFirstOfferId($productId) {
    $offer = CIBlockElement::GetList(
        ['SORT' => 'ASC'], // Сортировка
        [
            'IBLOCK_ID' => 2, // Замените на ID инфоблока предложений
            'PROPERTY_CML2_LINK' => $productId, // Связь с товаром
            'ACTIVE' => 'Y',
        ],
        false,
        ['nTopCount' => 1], // Берём только первое предложение
        ['ID']
    )->Fetch();

    return $offer ? $offer['ID'] : false;
}

// Получение общего количества товаров в корзине
function getBasketItemsCount() {
    $basketItems = CSaleBasket::GetList([], [
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => 'NULL'
    ]);

    $totalCount = 0;
    while ($item = $basketItems->Fetch()) {
        $totalCount += $item['QUANTITY']; // Учитываем количество каждого товара
    }

    return $totalCount;
}

if ($_POST["ajaxaddid"] && $_POST["ajaxaction"] == 'add') {
    $productId = intval($_POST["ajaxaddid"]);

    // Если товар с предложениями, ищем первое предложение
    $offerId = getFirstOfferId($productId);
    if (!$offerId) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Нельзя добавить в корзину товар без торговых предложений',
        ]);
        exit;
    }

    $result = Add2BasketByProductID($offerId, 1, []);
    if ($result) {
        $totalCount = getBasketItemsCount();

        echo json_encode([
            'status' => 'success',
            'basket_count' => $totalCount,
            'message' => 'Товар успешно добавлен в корзину',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ошибка добавления товара в корзину',
        ]);
    }
    exit;
}
