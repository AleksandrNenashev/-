<?
$start = microtime(true);
$_SERVER['DOCUMENT_ROOT'] = '/home/p4082/public_html';
	
$dir = '/home/p4082/public_html/catalog/new_export/';

function push_log($data){
	$date = date('H:i:s');
	$string = $date.' - '.$data."\r\n";
	$f = '/home/p4082/public_html/catalog/new_export/log.php';
	$result = file_put_contents($f, $string, FILE_APPEND);
}

$arParams['offers_props'] = array('SLEEP_SIZE', 'MATERIAL', 'COLOR', 'SHIRINA', 'DLINA', 'VISOTA', 'GLUBINA', 'DIAMETR');
$arParams['catalog_fields'] = array('DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_YA_SECT_VALUE', 'PREVIEW_PICTURE', 'PROPERTY_YA_DELIVERY_COST_VALUE', 'PROPERTY_MANUFACTURER_VALUE', 'DETAIL_TEXT', 'PROPERTY_WARRANTY_VALUE', 'PROPERTY_COUNTRY_VALUE');
$arParams['catalog_props'] = array('SERIES', 'DLINA_MATRASA', 'DLINA_SPAL_MESTA', 'OBIVKA', 'H_MATRASA', 'H_SPAL_MESTA', 'VISOTA_SPINKI', 'OTDELKA', 'STIL_MEB', 'OBIEM', 'KOLVO_PRUJIN', 'TKAN_CHEHLA', 'TKAN_POKRITIJA', 'TIP_NAMATRASNIKA', 'SEMNI_CHEHOL', 'P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7', 'P8', 'P9', 'P10', 'P14', 'P15', 'P23', 'P24', 'P25', 'P26', 'VISOTA_IZGOLOVIA');
$tab1 = '	';
$tab2 = '		';
$tab3 = '			';
$tab4 = '				';
$rn = "\r\n";
require_once($dir.'cur_step.php');


if($cur_step == 'step1'){
	file_put_contents($dir.'cur_step.php', '<?$cur_step = "wait";?>');

	require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

	CModule::IncludeModule("iblock");

	$rsSect = CIBlockSection::GetList(array(), array("IBLOCK_ID" => 1, "ACTIVE" => "Y"));
	while ($arSect = $rsSect->GetNext())
	{
		$section['ID'] = $arSect['ID'];
		$section['IBLOCK_SECTION_ID'] = $arSect['IBLOCK_SECTION_ID'];
		$section['NAME'] = $arSect['NAME'];
		$sections[] = $section;
	}
	
	if(!empty($sections)){
		$seri_sect = serialize($sections);
		$result = file_put_contents($dir.'cur_sections.php', $seri_sect);
	
		if($result !== false && $result > 0){
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "step2";?>');
		} else {
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
		}
	} else {
		file_put_contents($dir.'cur_step.php', '<?$cur_step = "step2";?>');
	}
}


if($cur_step == 'step2'){	
	file_put_contents($dir.'cur_step.php', '<?$cur_step = "wait";?>');

	if(empty($cur_page)){
		$cur_page = 1;
		file_put_contents($dir.'cur_catalog.php', '');
	}
	
	require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");

	$arSelect_catalog = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_TEXT", "SECTION_ID", "PROPERTY_YA_SECT", "PROPERTY_YA_DELIVERY_COST", "PROPERTY_MANUFACTURER", "PROPERTY_WARRANTY");
	$arFilter_catalog = Array("IBLOCK_ID" => 1, "ACTIVE"=>"Y", "!SECTION_ID" => "", "!DETAIL_PAGE_URL" => "");
	$res_catalog = CIBlockElement::GetList(Array(), $arFilter_catalog, false, array('nPageSize' => 500, 'iNumPage' => $cur_page), $arSelect_catalog);
	while($ob_catalog = $res_catalog->GetNextElement())
	{
		$arFields_catalog = $ob_catalog->GetFields();
		$arFields_catalog['PROPERTIES'] = $ob_catalog->GetProperties();
		foreach($arParams['catalog_fields'] as $field_code){
			$catalog[$arFields_catalog['ID']][$field_code] = $arFields_catalog[$field_code];
		}
		foreach($arParams['catalog_props'] as $prop_code){
			if(!empty($arFields_catalog['PROPERTIES'][$prop_code]['VALUE'])){
				$catalog[$arFields_catalog['ID']]['PROPERTIES'][$prop_code]['NAME'] = $arFields_catalog['PROPERTIES'][$prop_code]['NAME'];
				$catalog[$arFields_catalog['ID']]['PROPERTIES'][$prop_code]['VALUE'] = $arFields_catalog['PROPERTIES'][$prop_code]['VALUE'];
			}
		}
	}
	if(!empty($catalog)){
		$seri_cat = serialize($catalog);
		$result = file_put_contents($dir.'cur_catalog.php', $seri_cat."*-razdelitel-massivov-*", FILE_APPEND);
	
		if($result !== false && $result > 0){
			$cur_page++;
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "step2"; $cur_page = "'.$cur_page.'";?>');
		} else {
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
		}
		if(count($catalog) < 500){
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "step3";?>');
		}
	} else {
		file_put_contents($dir.'cur_step.php', '<?$cur_step = "step3";?>');
	}
}


if($cur_step == 'step3'){
	file_put_contents($dir.'cur_step.php', '<?$cur_step = "wait";?>');

	if(empty($cur_page)){
		$cur_page = 1;
		file_put_contents($dir.'cur_offers.php', '');
	}
	require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");

	$arSelect_offers = Array("ID", "NAME", "IBLOCK_ID", "CATALOG_GROUP_1", "CATALOG_PRICE_1", "PROPERTY_CML2_LINK", "PROPERTY_AVAILABLE", "PROPERTY_SLEEP_SIZE", "PROPERTY_MATERIAL", "PROPERTY_COLOR", "PROPERTY_SHIRINA", "PROPERTY_DLINA", "PROPERTY_VISOTA", "PROPERTY_GLUBINA", "PROPERTY_DIAMETR");
	$arFilter_offers = Array("IBLOCK_ID" => 2, "ACTIVE"=>"Y", "!PROPERTY_CML2_LINK" => "");
	$res_offers = CIBlockElement::GetList(Array(), $arFilter_offers, false, array('nPageSize' => 500, 'iNumPage' => $cur_page), $arSelect_offers);
	while($ob_offers = $res_offers->GetNextElement())
	{
		$arFields_offers = $ob_offers->GetFields();
		$arFields_offers['PROPERTIES'] = $ob_offers->GetProperties();

		$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
			$arFields_offers['ID'],
			2,
			"N",
			$arFields_offers['CATALOG_GROUP_ID_1']
		);
		$discountPrice = CCatalogProduct::CountPriceWithDiscount(
			$arFields_offers["CATALOG_PRICE_1"],
			$arFields_offers["CATALOG_CURRENCY_1"],
			$arDiscounts
		);
		$pre_offer['ID'] = $arFields_offers['ID'];
		$pre_offer['DISCOUNT_PRICE'] = $discountPrice;
		$pre_offer['PROPERTY_CML2_LINK_VALUE'] = $arFields_offers['PROPERTY_CML2_LINK_VALUE'];
		$pre_offer['PROPERTY_AVAILABLE_VALUE'] = $arFields_offers['PROPERTY_AVAILABLE_VALUE'];
		foreach($arParams['offers_props'] as $prop_code){
			if(!empty($arFields_offers['PROPERTIES'][$prop_code]['VALUE'])){
				$pre_offer['PROPERTIES'][$prop_code]['NAME'] = $arFields_offers['PROPERTIES'][$prop_code]['NAME'];
				$pre_offer['PROPERTIES'][$prop_code]['VALUE'] = $arFields_offers['PROPERTIES'][$prop_code]['VALUE'];
			}
		}
		$offers[] = $pre_offer;
	}
	if(!empty($offers)){
		$seri_off = serialize($offers);
		$result = file_put_contents($dir.'cur_offers.php', $seri_off."*-razdelitel-massivov-*", FILE_APPEND);
	
		if($result !== false && $result > 0){
			$cur_page++;
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "step3"; $cur_page = "'.$cur_page.'";?>');
		} else {
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
		}
		if(count($offers) < 500){
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "step4";?>');
		}
	} else {
		file_put_contents($dir.'cur_step.php', '<?$cur_step = "step4";?>');
	}
}
if($cur_step == 'step4'){
	file_put_contents($dir.'cur_step.php', '<?$cur_step = "wait";?>');
	
	require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	
	$seri_sect = file_get_contents($dir."cur_sections.php");
	$seri_cat = file_get_contents($dir."cur_catalog.php");
	$seri_off = file_get_contents($dir."cur_offers.php");
	
	$sections = unserialize($seri_sect);
	
	$ex_seri_cat = explode('*-razdelitel-massivov-*', $seri_cat);
	$catalog = array();
	foreach($ex_seri_cat as $ex_ser){
		if(!empty($ex_ser)){
			$part_cat = unserialize($ex_ser);
			$catalog = $catalog + $part_cat;
		}
	}

	$ex_seri_off = explode('*-razdelitel-massivov-*', $seri_off);
	$offers = array();
	foreach($ex_seri_off as $ex_off){
		if(!empty($ex_off)){
			$part_off = unserialize($ex_off);
			$offers = array_merge($offers, $part_off);
		}
	}
	
	if(!empty($sections) && !empty($catalog) && !empty($offers)){
		$file = $dir.'yandex_catalog.xml';
		file_put_contents($file, '');
		$handle = fopen($file, "c");
		
		if($handle == false){
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
		}
		
		$date = date('Y-m-d H:i');
$string = '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="'.$date.'">
	<shop>
		<name>belmebru.ru</name>
		<company>ООО «Белмебель»</company>
		<url>http://www.belmebru.ru/</url>

		<currencies>
			<currency id="RUR" rate="1" plus="0"/>
		</currencies>
		<categories>
';
		
		$result = fwrite($handle, $string);
		
		if($result == false or $result = 0){
			file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
		}

		foreach($sections as $sect){
			if(!empty($sect['IBLOCK_SECTION_ID'])){
				$parentId = ' parentId="'.$sect['IBLOCK_SECTION_ID'].'"';
			}
			$string = $tab3.'<category id="'.$sect['ID'].'"'.$parentId.'>'.$sect['NAME'].'</category>'.$rn;
			$result = fwrite($handle, $string);
			
			if($result == false or $result = 0){
				file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
			}
		}
		$string = $tab2.'</categories>'.$rn;
		$result = fwrite($handle, $string);
		
		$string = $tab2.'<local_delivery_cost>1250</local_delivery_cost>'.$rn;
		$result = fwrite($handle, $string);
		
		$string = $tab2.'<offers>'.$rn;
		$result = fwrite($handle, $string);
		
		foreach($offers as $offer){
			$parent = $offer['PROPERTY_CML2_LINK_VALUE'];
			if($offer['PROPERTY_AVAILABLE_VALUE'] == 'В наличии'){$available = 'true';} else {$available = 'false';}

			if(!empty($offer['ID']) && !empty($catalog[$parent]['DETAIL_PAGE_URL']) && !empty($offer['DISCOUNT_PRICE']) && !empty($catalog[$parent]['IBLOCK_SECTION_ID']) && !empty($catalog[$parent]['NAME'])){
			
				$string = $tab3.'<offer id="'.$offer['ID'].'" available="'.$available.'">'.$rn;
					$string .= $tab4.'<url>http://belmebru.ru'.$catalog[$parent]['DETAIL_PAGE_URL'].'?prod='.$offer['ID'].'</url>'.$rn;
					$string .= $tab4.'<price>'.$offer['DISCOUNT_PRICE'].'</price>'.$rn;
					$string .= $tab4.'<currencyId>RUR</currencyId>'.$rn;
					$string .= $tab4.'<categoryId>'.$catalog[$parent]['IBLOCK_SECTION_ID'].'</categoryId>'.$rn;
					$string .= $tab4.'<name>'.$catalog[$parent]['NAME'].'</name>'.$rn;
			
					if(!empty($catalog[$parent]['PROPERTY_YA_SECT_VALUE'])){
						$string .= $tab4.'<market_category>'.$catalog[$parent]['PROPERTY_YA_SECT_VALUE'].'</market_category>'.$rn;
					}
			
					if(!empty($catalog[$parent]['PREVIEW_PICTURE'])){
						$src = CFile::GetPath($catalog[$parent]['PREVIEW_PICTURE']);
						$string .= $tab4.'<picture>http://belmebru.ru'.$src.'</picture>'.$rn;
						unset($src);
					}
					$string .= $tab4.'<pickup>true</pickup>'.$rn;
					$string .= $tab4.'<delivery>true</delivery>'.$rn;
			
					if(!empty($catalog[$parent]['PROPERTY_YA_DELIVERY_COST_VALUE'])){
						$string .= $tab4.'<local_delivery_cost>'.$catalog[$parent]['PROPERTY_YA_DELIVERY_COST_VALUE'].'</local_delivery_cost>'.$rn;
					}
					if(!empty($catalog[$parent]['PROPERTY_MANUFACTURER_VALUE'])){
						$string .= $tab4.'<vendor>'.$catalog[$parent]['PROPERTY_MANUFACTURER_VALUE'].'</vendor>'.$rn;
					}
					if(!empty($catalog[$parent]['DETAIL_TEXT']) && strip_tags($catalog[$parent]['DETAIL_TEXT']) == $catalog[$parent]['DETAIL_TEXT']){
						$pre_string = $catalog[$parent]['DETAIL_TEXT'];
						$pre_string = str_replace('"', '&quot;', $pre_string);
						$pre_string = str_replace('&', '&amp;;', $pre_string);
						$pre_string = str_replace('>', '&gt;', $pre_string);
						$pre_string = str_replace('<', '&lt;', $pre_string);
						$pre_string = str_replace("'", '&apos;', $pre_string);
						$string .= $tab4.$pre_string.$rn;
					}
					if(!empty($catalog[$parent]['PROPERTY_WARRANTY_VALUE'])){
						$string .= $tab4.'<manufacturer_warranty>true</manufacturer_warranty>'.$rn;
					}
					if(!empty($catalog[$parent]['PROPERTY_COUNTRY_VALUE'])){
						$string .= $tab4.'<country_of_origin>'.$catalog[$parent]['PROPERTY_COUNTRY_VALUE'].'</country_of_origin>'.$rn;
					}
					foreach($arParams['offers_props'] as $prop_code){
						if(!empty($offer['PROPERTIES'][$prop_code]['VALUE'])){
							$string .= $tab4.'<param name="'.$offer['PROPERTIES'][$prop_code]['NAME'].'">'.$offer['PROPERTIES'][$prop_code]['VALUE'].'</param>'.$rn;
						}
					}
					foreach($arParams['catalog_props'] as $prop_code){
						if(!empty($catalog[$parent]['PROPERTIES'][$prop_code]['VALUE'])){
							$string .= $tab4.'<param name="'.$catalog[$parent]['PROPERTIES'][$prop_code]['NAME'].'">'.$catalog[$parent]['PROPERTIES'][$prop_code]['VALUE'].'</param>'.$rn;
						}
					}
				$string .= $tab3.'</offer>'.$rn;
			/*
			*/
						$result = fwrite($handle, $string);
			}


			
			if($result == false or $result = 0){
				file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
			}
		}
/*
*/
		$string = $tab2.'</offers>';
		$result = fwrite($handle, $string);
		$string = $tab1.'</shop>'.$rn;
		$result = fwrite($handle, $string);
		$string = '</yml_catalog>';
		$result = fwrite($handle, $string);
		
		fclose($handle);
		file_put_contents($dir.'cur_step.php', '<?$cur_step = "success";?>');
		$cur_step = "success";
	} else {
		file_put_contents($dir.'cur_step.php', '<?$cur_step = "error";?>');
	}
	$headers = "Content-type: text/html; charset=utf-8 \r\n"; 
	$headers .= "From: alex@flxmd.by";	
	mail("alex@flxmd.by", "trojCronJob", $cur_step, $headers);
}
$time = microtime(true) - $start;
if($cur_step != 'success' && $cur_step != 'error'){
	push_log($cur_step.' - '.$cur_page.' - work: '.$time);
}
?>