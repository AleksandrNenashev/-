<?
function getPrise_sale($parent_id, $show_date)
{
	
	if(!empty($parent_id))
	{
		
		global $USER;
		if(is_array($parent_id)){
			foreach($parent_id as $id){
				$cache_ind .= $id;
			}
		} else {
			$cache_ind = $parent_id;
		}
		$cache = new CPHPCache();
		$cache_time = 3600;
		$cache_id = 'getPrice_cache_reg-'.$_SESSION['region_price_id'].'_id-'.$cache_ind;
		$cache_path = '/getPrice_cache/';
		
		if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path))
		{
			
			$res = $cache->GetVars();
			
			if (is_array($res["ret"]) && (count($res["ret"]) > 0))
				$ret = $res["ret"];
				//echo '<pre style="display:block;">'; print_r($ret); echo '</pre>';
		}
		
		if (!is_array($ret))
		{
			$arSelect = Array("ID", "NAME", "CATALOG_GROUP_".$_SESSION['region_price_id'], "CATALOG_PRICE_".$_SESSION['region_price_id'], "PROPERTY_CML2_LINK", "PREVIEW_PICTURE", "PROPERTY_SIZE", "PROPERTY_PR100", "PROPERTY_NEWPRODUCT");
			$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $parent_id, "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0);
			
			$res = CIBlockElement::GetList(array("CATALOG_PRICE_".$_SESSION['region_price_id'] => "DESC"), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
					$arFields['ID'],
					$USER->GetUserGroupArray(),
					"N",
					$arFields['CATALOG_GROUP_ID_'.$_SESSION['region_price_id']]
				);
				
				if(!empty($arDiscounts))
				{
					if(!empty($arDiscounts[0]['ACTIVE_TO']))
					{
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
						
					}
					$discountPrice = CCatalogProduct::CountPriceWithDiscount(
						$arFields["CATALOG_PRICE_".$_SESSION['region_price_id']],
						$arFields["CATALOG_CURRENCY_".$_SESSION['region_price_id']],
						$arDiscounts
					);
					
					if(!empty($discountPrice)){
						$with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']][$arFields['ID']] = $discountPrice;
					}
		
					$el_arr[$arFields['ID']]['VALUE_NOVAT'] = intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']]);
					$el_arr[$arFields['ID']]['DISCOUNT_VALUE'] = intval($discountPrice);
					$el_arr[$arFields['ID']]['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($discountPrice, 'RUB');
			
					$el_arr[$arFields['ID']]['PROPERTIES']['SIZE']['VALUE'] = $arFields['PROPERTY_SIZE_VALUE'];
			
					if(intval($discountPrice) < intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']])){
						$el_arr[$arFields['ID']]['DISCOUNT_DIFF_PERCENT'] = 100 - round($discountPrice * 100 / intval($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']]));
						$el_arr[$arFields['ID']]['PRINT_VALUE_NOVAT'] = CurrencyFormat($arFields['CATALOG_PRICE_'.$_SESSION['region_price_id']], 'RUB');
					}
					if(count($with_discount[$arFields['PROPERTY_CML2_LINK_VALUE']]) > 1){
						$el_arr[$arFields['ID']]['FROM'] = 'Y';
					} else {
						$el_arr[$arFields['ID']]['ONE'] = intval($arFields['ID']);
					}
				}
			}
				
			foreach($with_discount as $pclv => &$p_id)
			{
				asort($p_id);
				
				foreach($p_id as $k => $v){
					$ret[$pclv] = $el_arr[$k];
					break;
				}
			}
			
			if ($cache_time > 0){
				$cache->StartDataCache($cache_time, $cache_id, $cache_path);
				$cache->EndDataCache(array("ret"=>$ret));
			}
		}
		return $ret;
	}
}
?>