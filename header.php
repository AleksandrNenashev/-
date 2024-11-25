<?
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

            <div class="main">
                <div class="container">
                    <div class="main-slider slider">
                        <?
                            global $arr_fltr;
                            $arr_fltr = array(
                                "SECTION_ID" => array(637),
                            ); ?>
                            <? $APPLICATION->IncludeComponent(
                            	"bitrix:news.list", 
                            	"main_slider4", 
                            	array(
                            		"DISPLAY_DATE" => "Y",
                            		"DISPLAY_NAME" => "Y",
                            		"DISPLAY_PICTURE" => "Y",
                            		"DISPLAY_PREVIEW_TEXT" => "Y",
                            		"AJAX_MODE" => "N",
                            		"IBLOCK_TYPE" => "informational",
                            		"IBLOCK_ID" => "6",
                            		"NEWS_COUNT" => "20",
                            		"SORT_BY1" => "ACTIVE_FROM",
                            		"SORT_ORDER1" => "DESC",
                            		"SORT_BY2" => "SORT",
                            		"SORT_ORDER2" => "ASC",
                            		"FILTER_NAME" => "arr_fltr",
                            		"FIELD_CODE" => array(
                            			0 => "",
                            			1 => "",
                            		),
                            		"PROPERTY_CODE" => array(
                            			0 => "link",
                            			1 => "",
                            		),
                            		"CHECK_DATES" => "N",
                            		"DETAIL_URL" => "",
                            		"PREVIEW_TRUNCATE_LEN" => "",
                            		"ACTIVE_DATE_FORMAT" => "d.m.Y",
                            		"SET_STATUS_404" => "N",
                            		"SET_TITLE" => "Y",
                            		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                            		"ADD_SECTIONS_CHAIN" => "Y",
                            		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            		"PARENT_SECTION" => "",
                            		"PARENT_SECTION_CODE" => "",
                            		"INCLUDE_SUBSECTIONS" => "Y",
                            		"CACHE_TYPE" => "A",
                            		"CACHE_TIME" => "36000000",
                            		"CACHE_FILTER" => "N",
                            		"CACHE_GROUPS" => "Y",
                            		"PAGER_TEMPLATE" => ".default",
                            		"DISPLAY_TOP_PAGER" => "N",
                            		"DISPLAY_BOTTOM_PAGER" => "Y",
                            		"PAGER_TITLE" => "Новости",
                            		"PAGER_SHOW_ALWAYS" => "Y",
                            		"PAGER_DESC_NUMBERING" => "N",
                            		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            		"PAGER_SHOW_ALL" => "Y",
                            		"AJAX_OPTION_JUMP" => "N",
                            		"AJAX_OPTION_STYLE" => "Y",
                            		"AJAX_OPTION_HISTORY" => "N",
                            		"AJAX_OPTION_ADDITIONAL" => "",
                            		"COMPONENT_TEMPLATE" => "main_slider4",
                            		"SET_BROWSER_TITLE" => "Y",
                            		"SET_META_KEYWORDS" => "Y",
                            		"SET_META_DESCRIPTION" => "Y",
                            		"SET_LAST_MODIFIED" => "N",
                            		"STRICT_SECTION_CHECK" => "N",
                            		"PAGER_BASE_LINK_ENABLE" => "N",
                            		"SHOW_404" => "N",
                            		"MESSAGE_404" => ""
                            	),
                            	false
                            ); ?>
                    </div>
                </div>
            </div>

            
                <?
                global $arr_fltr;
                $arr_fltr = array(
                    "IBLOCK_ID" => 25, // Указываем ID инфоблока вместо SECTION_ID
                    "ACTIVE" => "Y",   // Учитываем только активные элементы
                );
                ?>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "unic_offers",
                    array(
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "AJAX_MODE" => "N",
                        "IBLOCK_TYPE" => "informational",
                        "IBLOCK_ID" => 25, // Заменяем ID инфоблока на корректный
                        "NEWS_COUNT" => "3",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "arr_fltr",
                        "FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "link",
                            1 => "",
                        ),
                        "CHECK_DATES" => "N",
                        "DETAIL_URL" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "Y",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "PARENT_SECTION" => "", // Убираем раздел
                        "PARENT_SECTION_CODE" => "", // Убираем код раздела
                        "INCLUDE_SUBSECTIONS" => "N", // Убираем учет подразделов
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "PAGER_TEMPLATE" => ".default",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "Y",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "COMPONENT_TEMPLATE" => "unic_offers",
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_LAST_MODIFIED" => "N",
                        "STRICT_SECTION_CHECK" => "N",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "SHOW_404" => "N",
                        "MESSAGE_404" => ""
                    ),
                    false
                ); ?>
            
                <?
                global $arr_fltr;
                $arr_fltr = array(
                    "IBLOCK_ID" => 26, // Указываем ID инфоблока вместо SECTION_ID
                    "ACTIVE" => "Y",   // Учитываем только активные элементы
                );
                ?>
                <? $APPLICATION->IncludeComponent(
                    	"bitrix:news.list", 
                    	"popular_category", 
                    	array(
                    		"DISPLAY_DATE" => "N",
                    		"DISPLAY_NAME" => "N",
                    		"DISPLAY_PICTURE" => "Y",
                    		"DISPLAY_PREVIEW_TEXT" => "Y",
                    		"AJAX_MODE" => "N",
                    		"IBLOCK_TYPE" => "informational",
                    		"IBLOCK_ID" => "26",
                    		"NEWS_COUNT" => "9",
                    		"SORT_BY1" => "ACTIVE_FROM",
                    		"SORT_ORDER1" => "DESC",
                    		"SORT_BY2" => "SORT",
                    		"SORT_ORDER2" => "ASC",
                    		"FILTER_NAME" => "arr_fltr",
                    		"FIELD_CODE" => array(
                    			0 => "",
                    			1 => "",
                    		),
                    		"PROPERTY_CODE" => array(
                    			0 => "link",
                    			1 => "",
                    		),
                    		"CHECK_DATES" => "N",
                    		"DETAIL_URL" => "",
                    		"PREVIEW_TRUNCATE_LEN" => "",
                    		"ACTIVE_DATE_FORMAT" => "d.m.Y",
                    		"SET_STATUS_404" => "N",
                    		"SET_TITLE" => "N",
                    		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    		"ADD_SECTIONS_CHAIN" => "N",
                    		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    		"PARENT_SECTION" => "",
                    		"PARENT_SECTION_CODE" => "",
                    		"INCLUDE_SUBSECTIONS" => "N",
                    		"CACHE_TYPE" => "A",
                    		"CACHE_TIME" => "36000000",
                    		"CACHE_FILTER" => "N",
                    		"CACHE_GROUPS" => "Y",
                    		"PAGER_TEMPLATE" => ".default",
                    		"DISPLAY_TOP_PAGER" => "N",
                    		"DISPLAY_BOTTOM_PAGER" => "N",
                    		"PAGER_TITLE" => "Новости",
                    		"PAGER_SHOW_ALWAYS" => "Y",
                    		"PAGER_DESC_NUMBERING" => "N",
                    		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    		"PAGER_SHOW_ALL" => "N",
                    		"AJAX_OPTION_JUMP" => "N",
                    		"AJAX_OPTION_STYLE" => "Y",
                    		"AJAX_OPTION_HISTORY" => "N",
                    		"AJAX_OPTION_ADDITIONAL" => "",
                    		"COMPONENT_TEMPLATE" => "popular_category",
                    		"SET_BROWSER_TITLE" => "N",
                    		"SET_META_KEYWORDS" => "N",
                    		"SET_META_DESCRIPTION" => "N",
                    		"SET_LAST_MODIFIED" => "N",
                    		"STRICT_SECTION_CHECK" => "N",
                    		"PAGER_BASE_LINK_ENABLE" => "N",
                    		"SHOW_404" => "N",
                    		"MESSAGE_404" => ""
                    	),
                    	false
                    ); ?>

                    <?$APPLICATION->IncludeComponent("bitrix:main.include",
                                                     ".default", array(
													"AREA_FILE_SHOW" => "file",
													"PATH" => "/includes/sale_mob.php",
													"EDIT_TEMPLATE" => ""
													),
													false
												);?>

            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_DATE" => "N",
                    "DISPLAY_NAME" => "N",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array("",""),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "27",
                    "IBLOCK_TYPE" => "informational",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "N",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "4",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Новости",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array("link",""),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N"
                )
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
													"AREA_FILE_SHOW" => "file",
													"PATH" => "/includes/subscribe_mob.php",
													"EDIT_TEMPLATE" => ""
													),
													false
												);?>

            <div class="news m-section">
                <div class="container _type2">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:news.list", 
                        "main_blog1", 
                        array(
                            "IBLOCK_TYPE" => "informational",
                            "IBLOCK_ID" => "7",
                            "NEWS_COUNT" => "2",
                            "SORT_BY1" => "ACTIVE_FROM",
                            "SORT_ORDER1" => "DESC",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER2" => "ASC",
                            "FILTER_NAME" => "",
                            "FIELD_CODE" => array(
                                0 => "",
                                1 => "",
                            ),
                            "PROPERTY_CODE" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "N",
                            "AJAX_OPTION_HISTORY" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "ACTIVE_DATE_FORMAT" => "j F Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "PAGER_TEMPLATE" => ".default",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "PAGER_TITLE" => "Новости",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "N",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "COMPONENT_TEMPLATE" => "main_blog1",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "STRICT_SECTION_CHECK" => "N",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "SHOW_404" => "N",
                            "MESSAGE_404" => ""
                        ),
                        false
                    ); ?>
                </div>
            </div>

            <div class="advantages m-section">
                <div class="container">
                    <div class="h2 text-center">
                        Преимущества
                    </div>
                    <div class="advantages__grid">
                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_1.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                Мебель в кратчайшие сроки
                            </div>
                        </div>

                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_2.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                Доставляем в указанное время
                            </div>
                        </div>

                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_3.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                Всегда разные скидки
                            </div>
                        </div>

                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_4.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                вся мебель сертифицирована
                            </div>
                        </div>

                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_5.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                без посредников - без задержек!
                            </div>
                        </div>

                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_6.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                помощь специалистов
                            </div>
                        </div>

                        <div class="advantage-card">
                            <div class="advantage-card__img">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/av_7.png" alt="">
                            </div>
                            <div class="advantage-card__title">
                                любая мебель <br> на заказ
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="info m-section">
                <div class="container _type2">