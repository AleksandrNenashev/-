<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$subject = $_SERVER["REQUEST_URI"];
$pattern = '/\/\/+/';
$countReplace = 0;
$replaced_url = preg_replace($pattern, '/', $subject, -1, $countReplace);
if ($countReplace > 0)
	LocalRedirect($replaced_url, false, '301 Moved Permanently');

if ($USER->IsAdmin() && $_GET['off']) {
	$off = $_GET['off'];
}
if (!empty($_GET['region'])) {
	switch ($_GET['region']) {
		case 'kaz':
			$_SESSION['region_price'] = $_GET['region'];
			$_SESSION['region_price_id'] = 2;
			break;
		case 'msk':
			$_SESSION['region_price'] = 'RUB';
			$_SESSION['region_price_id'] = 1;
			break;
	}
} else {
	if (empty($_SESSION['region_price'])) {
		$_SESSION['region_price'] = 'RUB';
		$_SESSION['region_price_id'] = 1;
	}
}

CModule::IncludeModule("catalog");
$res = CCatalogGroup::GetListEx(array(), array(), false, false, array());
while ($group = $res->Fetch()) {
	if ($group['NAME'] == 'RUB') {
		$group['NAME'] = 'msk';
	}
	$reg[$group['ID']] = $group;
}


$cur_dir = $APPLICATION->GetCurDir();
$count_cur_dir = count(explode('/', $cur_dir));
$ex_cur_dir = explode('/', $cur_dir);


if (!empty($_SERVER['REAL_FILE_PATH'])) {
	$path = $_SERVER['REAL_FILE_PATH'];
} else {
	$path = $cur_dir;
}

$ex = explode('/', $path);
foreach ($ex as $k => $e) {
	if ($k < count($ex) - 1) {
		$new_ex .= $e . '/';
	}
}
//echo $_SERVER['REAL_FILE_PATH'];
$real_path = $_SERVER['DOCUMENT_ROOT'] . $new_ex;
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/libs.min.css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/style.min.css">
    <title>Главная</title>
	<? $APPLICATION->ShowHead(); ?>
</head>

<body class="m-page">
<? $APPLICATION->ShowPanel(); ?>
    <div class="wrapper">
        <header class="header">
            <div class="container _type2">
                <div class="header__inner">
                    <a href="/" class="header__logo">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/img/logo.png" alt="">
                    </a>

                    <div class="header-action">
                        <button class="burger _toggle-menu">
                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/burger.svg" alt="">
                        </button>
                        <button onclick="document.location='/catalog/'" class="catalog-btn">
                            <span>Каталог</span>
                        </button>

                        <div class="header-action__buttons">
                            <a href="/search/" class="header-action__btn">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/search.svg" alt="">
                            </a>
                            <?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.small", 
	"basket4", 
	array(
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_ORDER" => "/personal/cart/",
		"SHOW_DELAY" => "N",
		"SHOW_NOTAVAIL" => "N",
		"SHOW_SUBSCRIBE" => "N",
		"COMPONENT_TEMPLATE" => "basket4"
	),
	false
);?>
                        </div>
                    </div>

                    <div class="header-call">
                        <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/includes/phone_mob.php"
                                )
                            );?>
                    </div>
                </div>
            </div>

            <div class="fix-header">

            </div>


            <div class="mob-menu">
                <div class="mob-menu__bg _toggle-menu"></div>
                <div class="mob-menu__inner">
				<? $APPLICATION->IncludeComponent(
                        "bitrix:menu", 
                        "cat_menu_2line1", 
                        array(
                            "ROOT_MENU_TYPE" => "catalog",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "catalog2",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => "cat_menu_2line1"
                        ),
                        false
                    ); ?>
                </div>
            </div>

        </header>
        <main class="content">