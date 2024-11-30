<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
?>
<?
$arSelect = Array("ID", "PROPERTY_MIN_PRICE", "PROPERTY_MAX_PRICE");
$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y", "PROPERTY_MIN_PRICE" => false, "PROPERTY_MAX_PRICE" => false);
$res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, Array ("nTopCount" => 10000), $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();

	$arSelect2 = Array("ID", "CATALOG_PRICE_1");
	$arFilter2 = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $arFields['ID']);
	$res2 = CIBlockElement::GetList(Array("CATALOG_PRICE_1" => "ASC"), $arFilter2, false, Array ("nTopCount" => 1), $arSelect2);
	while($ob2 = $res2->GetNextElement())
	{
		$arFields2 = $ob2->GetFields();
		CIBlockElement::SetPropertyValuesEx($arFields['ID'], 1, array('MIN_PRICE' => intval($arFields2['CATALOG_PRICE_1'])));
	}

	$arSelect3 = Array("ID", "CATALOG_PRICE_1");
	$arFilter3 = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $arFields['ID']);
	$res3 = CIBlockElement::GetList(Array("CATALOG_PRICE_1" => "DESC"), $arFilter3, false, Array ("nTopCount" => 1), $arSelect3);
	while($ob3 = $res3->GetNextElement())
	{
		$arFields3 = $ob3->GetFields();
		CIBlockElement::SetPropertyValuesEx($arFields['ID'], 1, array('MAX_PRICE' => intval($arFields3['CATALOG_PRICE_1'])));
	}
	//echo $arFields['ID'].'<br />';
}
?>