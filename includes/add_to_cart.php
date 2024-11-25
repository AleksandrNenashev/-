<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();
$productId = $request->getPost('id');

if ($productId) {
    if (Add2BasketByProductID($productId)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Не удалось добавить товар.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Не указан ID товара.']);
}
?>