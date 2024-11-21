<?
$cache = new CPHPCache();
$cache_time = 86400;
$cache_id = 'discounts_cache';
$cache_path = '/discounts_cache/';

if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)){
	$res = $cache->GetVars();
	if (is_array($res["ids"]) && (count($res["ids"]) > 0))
		$ids = $res["ids"];
}
if (!is_array($ids)){
	$dbProductDiscounts = CCatalogDiscount::GetList(
		array("RAND" => "ASC"),
		array(
			"ACTIVE" => "Y",
			"!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), 
					   "YYYY-MM-DD HH:MI:SS",
					   CSite::GetDateFormat("FULL")),
			"!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), 
					 "YYYY-MM-DD HH:MI:SS", 
					 CSite::GetDateFormat("FULL")),
			"COUPON" => ""
		),
		false,
		false,
		array(
			"ID", "SITE_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO", 
			"RENEWAL", "NAME", "SORT", "MAX_DISCOUNT", "VALUE_TYPE", 
			"VALUE", "CURRENCY", "PRODUCT_ID"
			)
		);
	while ($arProductDiscounts = $dbProductDiscounts->Fetch())
	{
		$sku_id[] = $arProductDiscounts['PRODUCT_ID'];
	}

	if(!empty($sku_id)){
		$arSelect = Array("ID", "NAME", "PROPERTY_CML2_LINK");
		$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "ID" => $sku_id);
		$res = CIBlockElement::GetList(array("RAND" => "ASC"), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$ids[] = $arFields['PROPERTY_CML2_LINK_VALUE'];
		}
	}

	if ($cache_time > 0){
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(array("ids"=>$ids));
	}
}

if ($ids){
	shuffle($ids);
}

global $arFilSale;
$arFilSale = array("ID" => $ids[0]);
//*/
if(!empty($ids[0])){
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"sale", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "1",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_TOVAROV",
			1 => "UF_POP",
			2 => "",
		),
		"ELEMENT_SORT_FIELD" => "RAND",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arFilSale",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "1",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "YA_SECT",
			1 => "YA_DELIVERY_COST",
			2 => "PR100",
			3 => "SALE",
			4 => "ARTNUMBER",
			5 => "BAZOVI_BLOCK_MAT",
			6 => "VID_POSTAVKI",
			7 => "HEIGHT",
			8 => "VISOTA_BEZ_CHEHLA",
			9 => "VISOTA_SPINKI",
			10 => "VISOTA_IZGOLOVIA",
			11 => "WARRANTY",
			12 => "DEPTH",
			13 => "CITY",
			14 => "DIAMETR",
			15 => "LENGHT",
			16 => "DLINA_MATRASA",
			17 => "P26",
			18 => "P25",
			19 => "DLINA_SPAL_MESTA",
			20 => "DOPUST_RAZ_VES",
			21 => "META_TITLE",
			22 => "ZERKALO",
			23 => "META_KEYWORDS",
			24 => "P15",
			25 => "P24",
			26 => "P1",
			27 => "KOLVO_PAKETOV",
			28 => "P2",
			29 => "KOLVO_PRUJIN",
			30 => "P11",
			31 => "P20",
			32 => "KREPLENIE",
			33 => "SALELEADER",
			34 => "MAX_NAGRUZKA",
			35 => "P13",
			36 => "P22",
			37 => "MATERIAL",
			38 => "P5",
			39 => "P10",
			40 => "META_DESCRIPTION",
			41 => "MECH",
			42 => "P4",
			43 => "TOP_INDEX",
			44 => "P8",
			45 => "NAL_MESTA",
			46 => "NALISHIE_MATRASA",
			47 => "P12",
			48 => "P21",
			49 => "NEWPRODUCT",
			50 => "OBIVKA",
			51 => "P14",
			52 => "P23",
			53 => "OBIEM",
			54 => "OTDELKA",
			55 => "PODAROK",
			56 => "TO_MAIN_MENU",
			57 => "RECOMMEND2",
			58 => "MANUFACTURER",
			59 => "SIZE",
			60 => "RAZMER",
			61 => "RASPOLOHENIE",
			62 => "P9",
			63 => "SERIES",
			64 => "SERIA",
			65 => "RECOMMEND",
			66 => "SPECIALOFFER",
			67 => "SPOSOB_CHISTKI",
			68 => "RETURN",
			69 => "SROK_SLUHBI",
			70 => "STIL_MEB",
			71 => "COUNTRY",
			72 => "STRANA",
			73 => "SEMNI_CHEHOL",
			74 => "TIP_NAMATRASNIKA",
			75 => "P3",
			76 => "TKAN_POKRITIJA",
			77 => "TKAN_CHEHLA",
			78 => "OFF",
			79 => "UROVEN_JESKOSTI_VERH",
			80 => "UROVEN_JESKOSTI_NIJ",
			81 => "USLOVIA_DOST",
			82 => "FURNITURA",
			83 => "COLOR",
			84 => "P7",
			85 => "P6",
			86 => "WIDTH",
			87 => "H_MATRASA",
			88 => "H_SPAL_MESTA",
			89 => "WD_EXCEL_IMPORT_ID",
			90 => "DELETE",
			91 => "MIN_PRICE",
			92 => "MAX_PRICE",
			93 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SLEEP_SIZE",
			1 => "MATERIAL",
			2 => "COLOR",
			3 => "SHIRINA",
			4 => "DLINA",
			5 => "VISOTA",
			6 => "GLUBINA",
			7 => "SIZE",
			8 => "DIAMETR",
			9 => "DELETE",
			10 => "AVAILABLE",
			11 => "POSTAVKA",
			12 => "WD_EXCEL_IMPORT_ID",
			13 => "",
		),
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
		"CACHE_TYPE" => "N",
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
		"PRICE_CODE" => array(
			0 => "RUB",
		),
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
		"PRODUCT_PROPERTIES" => array(
			0 => "SALE",
			1 => "SALELEADER",
			2 => "TOP_INDEX",
			3 => "NEWPRODUCT",
			4 => "TO_MAIN_MENU",
			5 => "RECOMMEND2",
			6 => "RECOMMEND",
			7 => "SPECIALOFFER",
		),
		"OFFERS_CART_PROPERTIES" => array(
			0 => "SLEEP_SIZE",
			1 => "MATERIAL",
			2 => "COLOR",
			3 => "SHIRINA",
			4 => "DLINA",
			5 => "VISOTA",
			6 => "GLUBINA",
			7 => "SIZE",
			8 => "DIAMETR",
			9 => "DELETE",
			10 => "AVAILABLE",
			11 => "POSTAVKA",
			12 => "WD_EXCEL_IMPORT_ID",
		),
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
	),
	false
);?>
<?}?>