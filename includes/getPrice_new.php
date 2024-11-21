<?
function getPrise($parent_id, $show_date){
	global $USER;
	$arSelect = Array("ID", "NAME", "CATALOG_GROUP_1", "PROPERTY_CML2_LINK", "PREVIEW_PICTURE", "PROPERTY_SIZE", "PROPERTY_PR100", "PROPERTY_NEWPRODUCT");
	$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $parent_id, "!CATALOG_PRICE_1" => 0);
	$res = CIBlockElement::GetList(array("CATALOG_PRICE_1" => "DESC"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
			$arFields['ID'],
			$USER->GetUserGroupArray(),
			"N",
			$arFields['CATALOG_GROUP_ID_1']
		);

		if(!empty($arDiscounts[0]['ACTIVE_TO'])){
			$ex_date = explode(' ', $arDiscounts[0]['ACTIVE_TO']);
			$ex_date_d = explode('.', $ex_date[0]);
			$ex_date_t = explode(':', $ex_date[1]);

			$formated_date[d] = $ex_date_d[0];
			$formated_date[m] = $ex_date_d[1];
			$formated_date[y] = $ex_date_d[2];
			$formated_date[hh] = $ex_date_t[0];
			$formated_date[mm] = $ex_date_t[1];
			$formated_date[ss] = $ex_date_t[2];
			$el_arr[$arFields['ID']]['ACTIVE_TO'] = $formated_date;
			//$el_arr[$arFields['ID']]['ACTIVE_TO2'] = $arDiscounts[0]['ACTIVE_TO'];
		}

		$discountPrice = CCatalogProduct::CountPriceWithDiscount(
			$arFields["CATALOG_PRICE_1"],
			$arFields["CATALOG_CURRENCY_1"],
			$arDiscounts
		);
		$with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']][$arFields['ID']] = $discountPrice;

		//$el_arr[$arFields['ID']]['ID'] = intval($arFields['ID']);
		$el_arr[$arFields['ID']]['VALUE_NOVAT'] = intval($arFields['CATALOG_PRICE_1']);
		$el_arr[$arFields['ID']]['DISCOUNT_VALUE'] = intval($discountPrice);
		//$el_arr[$arFields['ID']]['REAL_PRICE_FORMATED'] = CurrencyFormat($arFields['CATALOG_PRICE_1'], 'RUB');
		$el_arr[$arFields['ID']]['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($discountPrice, 'RUB');

		//$el_arr[$arFields['ID']]['PROPERTIES']['SIZE']['VALUE'] = $arFields['PROPERTY_SIZE_VALUE'];
		//$el_arr[$arFields['ID']]['PROPERTIES']['PR100']['VALUE'] = $arFields['PROPERTY_PR100_VALUE'];
		//$el_arr[$arFields['ID']]['PROPERTIES']['NEWPRODUCT']['VALUE'] = $arFields['PROPERTY_NEWPRODUCT_VALUE'];

		if(intval($discountPrice) < intval($arFields['CATALOG_PRICE_1'])){
			$el_arr[$arFields['ID']]['DISCOUNT_DIFF_PERCENT'] = 100 - round($discountPrice * 100 / intval($arFields['CATALOG_PRICE_1']));
			$el_arr[$arFields['ID']]['PRINT_VALUE_NOVAT'] = CurrencyFormat($arFields['CATALOG_PRICE_1'], 'RUB');
		}


	}
	foreach($with_discount as &$p_id){
		asort($p_id);
		foreach($p_id as $k => $v){
			$ret[$arFields['PROPERTY_CML2_LINK_VALUE']] = $el_arr[$k];
			break;
		}
	}
	return $ret;
}
?>