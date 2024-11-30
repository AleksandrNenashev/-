<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
?>
<?
$arSelect = Array("ID", "PROPERTY_MIN_PRICE", "PROPERTY_MAX_PRICE");
$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y", "!PROPERTY_MIN_PRICE" => false, "!PROPERTY_MAX_PRICE" => false);
$res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, Array ("nTopCount" => 10000), $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	CIBlockElement::SetPropertyValuesEx($arFields['ID'], 1, array('MIN_PRICE' => ''));
	CIBlockElement::SetPropertyValuesEx($arFields['ID'], 1, array('MAX_PRICE' => ''));
	//echo $arFields['ID'].'<br />';
}
?>