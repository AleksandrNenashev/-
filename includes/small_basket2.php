<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("");

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

if($_POST["ajaxaddid"] && $_POST["ajaxaction"] == 'add'){
    $res = Add2BasketByProductID($_POST["ajaxaddid"], 1, array());
		?>
		<span style="display:none;"><?=$res?></span>
		<?
}?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.small",
	"basket2",
	Array(
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_ORDER" => "/personal/cart/",
		"SHOW_DELAY" => "N",
		"SHOW_NOTAVAIL" => "Y",
		"SHOW_SUBSCRIBE" => "Y"
	)
);?>
<span class="cart-counter"><?= $quantity ?></span>