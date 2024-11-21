<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?require_once($_SERVER["DOCUMENT_ROOT"].'/includes/getPrice.php')?>
<?
unset($arResult["CATEGORIES"]['all']);

foreach($arResult["CATEGORIES"] as $category_id => $arCategory){
	foreach($arCategory["ITEMS"] as $i => $arItem){
		if($arItem['ITEM_ID'][0] != 'S' && $arItem['NAME'] != 'остальные'){
			$ids[] = $arItem['ITEM_ID'];
		}
	}
}

$prices = getPrise($ids);


foreach($arResult["CATEGORIES"] as $category_id => &$arCategory){
	foreach($arCategory["ITEMS"] as $i => &$arItem){
		if($arItem['ITEM_ID'][0] != 'S' && $arItem['NAME'] != 'остальные'){
			if(!empty($prices[$arItem['ITEM_ID']])){
				$arItem['PRICES']['RUB'] = $prices[$arItem['ITEM_ID']];
			}else{

				$ar_res = CCatalogProduct::GetByID($arItem['ITEM_ID']);

				if( CCatalogProductSet::isProductInSet($arItem['ITEM_ID'], CCatalogProductSet::TYPE_SET))
				{
					$dbProductPrice = CPrice::GetListEx(
						array(),
						array("PRODUCT_ID" => $arItem['ITEM_ID'], 'CATALOG_GROUP_ID' => $_SESSION['region_price_id']),
						false,
						false,
						array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "QUANTITY_FROM", "QUANTITY_TO")
					);
					$tmp = [];

					if($arProductPrice = $dbProductPrice->Fetch() ) 
					{

						$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
							$arItem['ITEM_ID'],
							$USER->GetUserGroupArray(),
							"N",
							Array($arProductPrice['CATALOG_GROUP_ID']),
							SITE_ID
						);

						$discountPrice = CCatalogProduct::CountPriceWithDiscount(
							$arProductPrice['PRICE'],
							$arProductPrice["CURRENCY"],
							$arDiscounts
						);

						$tmp['VALUE_NOVAT'] = intval($arProductPrice['PRICE']);
						$tmp['DISCOUNT_VALUE'] = intval($discountPrice);
						$tmp['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($discountPrice, 'RUB');
			
						if(intval($discountPrice) < intval($arProductPrice['PRICE']))
						{
							$tmp['DISCOUNT_DIFF_PERCENT'] = 100 - round($discountPrice * 100 / intval($arProductPrice['PRICE']));
							$tmp['PRINT_VALUE_NOVAT'] = CurrencyFormat($arProductPrice['PRICE'], 'RUB');
						}

						$arItem['PRICES']['RUB'] = $tmp;

					}
				}

			}
		}
	}
}



