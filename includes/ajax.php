<?php
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    // Проверка, что товар существует
    if (CIBlockElement::GetByID($productId)->Fetch()) {
        // Добавление товара в корзину
        Add2BasketByProductID($productId, 1);  // Добавить 1 штуку товара

        // Получение информации о корзине
        $basket = CSaleBasket::GetList([], ["FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"], false, false, ["QUANTITY", "PRICE"]);
        $quantity = 0;
        $sum = 0;
        while ($item = $basket->Fetch()) {
            $quantity += $item['QUANTITY'];
            $sum += $item['PRICE'] * $item['QUANTITY'];
        }

        // Возвращаем обновленные данные
        echo json_encode(['success' => true, 'quantity' => $quantity, 'sum' => CurrencyFormat($sum, 'RUB')]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Товар не найден']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Некорректный ID товара']);
}
?>
