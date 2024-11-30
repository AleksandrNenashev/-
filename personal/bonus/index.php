<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бонусный счёт");
?> <?$APPLICATION->IncludeComponent(
	"bitrix:sale.affiliate.instructions",
	"bonus",
	Array(
		"SHOP_NAME" => "belmebru.ru",
		"SHOP_URL" => "belmebru.ru",
		"REGISTER_PAGE" => "register.php",
		"AFF_REG_PAGE" => "/affiliate/register.php",
		"SET_TITLE" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>