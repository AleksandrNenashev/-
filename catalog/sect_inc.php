<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"inner_left_menu",
	Array(
	)
);?>
<?include $_SERVER['DOCUMENT_ROOT'].'/includes/main_sale.php';?>
 
<?global $sect_id;?> <?global $showfilter; if($showfilter == 'y'){?> <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"smart", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "1",
		"SECTION_ID" => $sect_id,
		"FILTER_NAME" => "arrFilterCat",
		"HIDE_NOT_AVAILABLE" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"INSTANT_RELOAD" => "Y",
		"PRICE_CODE" => array(
			0 => "RUB",
		),
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "-",
		"SECTION_DESCRIPTION" => "-",
		"TEMPLATE_THEME" => "blue"
	),
	false
);?> <?}?>
 <div class="advantages_belmeb-wr">
<span class="adv-bottom-title">Преимущества</span>
<div class="advantages_belmeb">
 
<div class="bottom-av bottom-av1"><span>Мебель в<br>кратчайшие сроки</span></div>
<div class="bottom-av bottom-av2"><span>Доставляем в <br> указанное время</span></div>
<div class="bottom-av bottom-av3"><span>Всегда разные <br> скидки</span></div>
<div class="bottom-av bottom-av4"><span>вся мебель<br>сертифицирована</span></div>
<div class="bottom-av bottom-av5"><span>без посредников<br>- без задержек!</span></div>
<div class="bottom-av bottom-av6"><span>помощь<br>квалифицированных специалистов</span></div>
<div class="bottom-av bottom-av7"><span>любая мебель<br> на заказ</span></div>
</div>
</div>