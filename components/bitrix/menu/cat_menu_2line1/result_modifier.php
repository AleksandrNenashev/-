<?require_once($_SERVER["DOCUMENT_ROOT"].'/includes/getPrice.php')?>
<?
$k1 = 0;
$k2 = 0;
$k3 = 0;
foreach($arResult as $arItem){
	global $USER;
	switch ($arItem['DEPTH_LEVEL']) {
	    case 1:
		$k1++;

		$arFields = '';
		$arOrder = Array('RAND' => 'ASC');
		$arNavStart = Array('nTopCount' => 1);
		$arSelect = Array('ID', 'NAME', 'PROPERTY_TO_MAIN_MENU', 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL', 'NEW_PRODUCT', 'PR100');
		$arFilter = Array('IBLOCK_ID' => 1, 'ACTIVE'=>'Y', 'SECTION_ID' => $arItem['PARAMS']['SECTION_ID'], 'INCLUDE_SUBSECTIONS' => 'Y', 'PROPERTY_TO_MAIN_MENU_VALUE' => 'Да');
		$res = CIBlockElement::GetList($arOrder, $arFilter, false, $arNavStart, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$arFields['PROPERTIES'] = $ob->GetProperties();
			$ids = $arFields['ID'];
			$prices = getPrise($ids);
			$arFields['PRICES']['RUB'] = $prices[$arFields['ID']];
		}
		$arItem['SHOW_ITEM'] = $arFields;

	        $arResult2[$k1] = $arItem;
	        break;
	    case 2:
		$k2++;
	        $arResult2[$k1]['CHILDS'][$k2] = $arItem;
	        break;
	    case 3:
		$k3++;
	        $arResult2[$k1]['CHILDS'][$k2]['CHILDS'][$k3] = $arItem;
	        break;
	}
}
//$arResult2 = array_merge($arResult2,$arResult2);

//удаляем ссылку на распродажу из меню
$arResult2_new = array();
foreach($arResult2 as $item)
{
	if ( $item['LINK']!=='/catalog/_rasprodazha/' && $item['LINK'] !=='/catalog/mebel-na-zakaz/')
	{
		$arResult2_new[] = $item;
	}
}

$arResult2 = $arResult2_new;

$arResult = $arResult2;
?>
