<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array('LIST', 'LINE', 'TEXT', 'TILE');

$arDefaultParams = array(
	'VIEW_MODE' => 'LIST',
	'SHOW_PARENT_NAME' => 'Y',
	'HIDE_SECTION_NAME' => 'N'
);

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList))
	$arParams['VIEW_MODE'] = 'LIST';
if ('N' != $arParams['SHOW_PARENT_NAME'])
	$arParams['SHOW_PARENT_NAME'] = 'Y';
if ('Y' != $arParams['HIDE_SECTION_NAME'])
	$arParams['HIDE_SECTION_NAME'] = 'N';

$arResult['VIEW_MODE_LIST'] = $arViewModeList;

if (0 < $arResult['SECTIONS_COUNT'])
{
	if ('LIST' != $arParams['VIEW_MODE'])
	{
		$boolClear = false;
		$arNewSections = array();
		foreach ($arResult['SECTIONS'] as &$arOneSection)
		{
			if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL'])
			{
				$boolClear = true;
				continue;
			}
			$arNewSections[] = $arOneSection;
		}
		unset($arOneSection);
		if ($boolClear)
		{
			$arResult['SECTIONS'] = $arNewSections;
			$arResult['SECTIONS_COUNT'] = count($arNewSections);
		}
		unset($arNewSections);
	}
}

if (0 < $arResult['SECTIONS_COUNT'])
{
	$boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	if ('LINE' == $arParams['VIEW_MODE'] || 'TILE' == $arParams['VIEW_MODE'])
	{
		reset($arResult['SECTIONS']);
		$arCurrent = current($arResult['SECTIONS']);
		if (!isset($arCurrent['PICTURE']))
		{
			$boolPicture = true;
			$arSelect[] = 'PICTURE';
		}
		if ('LINE' == $arParams['VIEW_MODE'] && !array_key_exists('DESCRIPTION', $arCurrent))
		{
			$boolDescr = true;
			$arSelect[] = 'DESCRIPTION';
			$arSelect[] = 'DESCRIPTION_TYPE';
		}
	}
	if ($boolPicture || $boolDescr)
	{
		foreach ($arResult['SECTIONS'] as $key => $arSection)
		{
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext())
		{
			if (!isset($arMap[$arSection['ID']]))
				continue;
			$key = $arMap[$arSection['ID']];
			if ($boolPicture)
			{
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr)
			{
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	}
}
?>
<?
if(!empty($arResult['SECTIONS'])){
	foreach($arResult['SECTIONS'] as &$arSection){
		$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "SECTION_ID", "CATALOG_GROUP_".$_SESSION['region_price_id'], "CATALOG_PRICE_".$_SESSION['region_price_id']);
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "SECTION_ID" => $arSection["ID"], "INCLUDE_SUBSECTIONS" => "Y");
		$arNav = Array ("nTopCount" => 9);
		$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, $arNav, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$arProperties = $ob->GetProperties();
			$arFields['PROPERTIES'] = $arProperties;
			$fileArray = CFile::GetFileArray($arFields['~PREVIEW_PICTURE']);
			$file = CFile::ResizeImageGet($fileArray, array('width'=>'215', 'height'=>170), BX_RESIZE_IMAGE_PROPORTIONAL, false);
			$arFields['PREVIEW_PICTURE_SRC'] = $file['src'];

                        if($arFields["CATALOG_PRICE_".$_SESSION['region_price_id']]) $idsNoSKU[] = $arFields['ID'];
                                else  $ids[] = $arFields['ID'];

			$arSection['ELEMENTS'][] = $arFields;
		}
	}
	?>
	<?require_once($_SERVER["DOCUMENT_ROOT"].'/includes/getPrice.php')?>
	<?require_once($_SERVER["DOCUMENT_ROOT"].'/includes/getPriceNoSKU.php')?>
	<?
	if($ids)
	{
		$prices = getPrise($ids);
		foreach($arResult['SECTIONS'] as &$arSection)
		{
			foreach($arSection['ELEMENTS'] as &$arItem)
			{
				if(!empty($prices[$arItem['ID']]))
				{
					$arItem['PRICES']['RUB'] = $prices[$arItem['ID']];
				}
			}
		}
	}

	if($idsNoSKU)
	{
		$prices = getPriceNoSKU($idsNoSKU);

		foreach($arResult['SECTIONS'] as &$arSection)
		{
			foreach($arSection['ELEMENTS'] as &$arItem)
			{
				if(!empty($prices[$arItem['ID']])) $arItem['PRICES']['RUB'] = $prices[$arItem['ID']];
			}
		}
	}

}
?>