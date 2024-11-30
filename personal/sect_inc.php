<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"sidebar3",
	Array(
		"ROOT_MENU_TYPE" => "lc",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	)
);?> <?$APPLICATION->IncludeComponent(
	"bitrix:main.profile",
	"balance",
	Array(
	)
);?> 
<div class="subscribe_ajax2"> 	<?include $_SERVER['DOCUMENT_ROOT'].'/includes/subscribe2.php';?> </div>   
