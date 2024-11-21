<?
function getPrise($parent_id){
	global $USER;
	$arSelect = Array("ID", "NAME", "CATALOG_GROUP_1", "PROPERTY_CML2_LINK", "PREVIEW_PICTURE", "PROPERTY_SIZE", "PROPERTY_PR100", "PROPERTY_NEWPRODUCT");
	$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $parent_id, "!CATALOG_PRICE_1" => 0);
	$res = CIBlockElement::GetList(array("CATALOG_PRICE_1" => "DESC"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		unset($arFields);
		unset($arDiscounts);
		unset($disc);
		unset($discountPrice);
		$arFields = $ob->GetFields();
		$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
			$arFields['ID'],
			$USER->GetUserGroupArray(),
			"N",
			$arFields['CATALOG_GROUP_ID_1']
		);
		$disc[$arFields['ID']] = $arDiscounts;
		$discountPrice = CCatalogProduct::CountPriceWithDiscount(
			$arFields["CATALOG_PRICE_1"],
			$arFields["CATALOG_CURRENCY_1"],
			$arDiscounts
		);
		
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['ID'] = intval($arFields['ID']);
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['REAL_PRICE'] = intval($arFields['CATALOG_PRICE_1']);
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['PRICE'] = intval($discountPrice);
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['REAL_PRICE_FORMATED'] = CurrencyFormat($arFields['CATALOG_PRICE_1'], 'RUB');
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['PRICE_FORMATED'] = CurrencyFormat($discountPrice, 'RUB');
		$src = CFile::GetPath($arFields['PREVIEW_PICTURE']);
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['PREVIEW_PICTURE']['SRC'] = $src;

		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['PROPERTIES']['SIZE']['VALUE'] = $arFields['PROPERTY_SIZE_VALUE'];
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['PROPERTIES']['PR100']['VALUE'] = $arFields['PROPERTY_PR100_VALUE'];
		$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['PROPERTIES']['NEWPRODUCT']['VALUE'] = $arFields['PROPERTY_NEWPRODUCT_VALUE'];

		if(intval($discountPrice) < intval($arFields['CATALOG_PRICE_1'])){
			$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['DISCOUNT_DIFF_PERCENT'] = intval(intval($discountPrice) * 100 / intval($arFields['CATALOG_PRICE_1']));
			$ret[$arFields['PROPERTY_CML2_LINK_VALUE']]['OLD_PRICE'] = CurrencyFormat($arFields['CATALOG_PRICE_1'], 'RUB');
		}
	}
	return $ret;
}
?>