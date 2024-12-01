 <? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?
$current_url = $_SERVER['REQUEST_URI'];
if ($current_url == '/' || $current_url == '/index.php') {
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list", 
		"brands_mobile", 
		array(
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "8",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"COUNT_ELEMENTS" => "N",
			"TOP_DEPTH" => "1",
			"SECTION_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"SECTION_URL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_GROUPS" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"VIEW_MODE" => "LINE",
			"SHOW_PARENT_NAME" => "Y",
			"COMPONENT_TEMPLATE" => "brands",
			"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
			"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
			"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
			"FILTER_NAME" => "sectionsFilter",
			"CACHE_FILTER" => "N"
		),
		false
	);

	?>
	</div>
	</div>
		
	<div class="feedback m-section">
		<div class="container">
			<div class="h1 text-center">
				Давайте общаться!
			</div>
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/includes/social_mobile.php",
									"EDIT_TEMPLATE" => ""
									),
									false
								);?>
		</div>

	</div>

	<?}?>
        </main>
        <footer class="footer">
            <div class="footer-top">
                <div class="container _type2">
                    <div class="footer-top__inner">
                        <a href="" class="footer__logo">
                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/logo2.png" alt="">
                        </a>
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => "/includes/header_contacts_mobile.php",
				"EDIT_TEMPLATE" => ""
				),
				false
			);?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu", 
				"other_mobile", 
				array(
					"ROOT_MENU_TYPE" => "other",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(
					),
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "left",
					"USE_EXT" => "N",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N"
				),
				false
			);?>

                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container _type2">
                    <div class="footer-bottom__inner">
                        <div class="footer-menu">
                            <div class="footer-nav">
                                <?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"bottom_menu_mob", 
								array(
									"ROOT_MENU_TYPE" => "top",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "left",
									"USE_EXT" => "N",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N",
									"COMPONENT_TEMPLATE" => "bottom_menu_mob"
								),
								false
							);?>
                            </div>
                            <div class="footer-nav _type2">

                                <?$APPLICATION->IncludeComponent(
									"bitrix:menu", 
									"bottom_menu_mob2", 
									array(
										"ROOT_MENU_TYPE" => "about",
										"MENU_CACHE_TYPE" => "A",
										"MENU_CACHE_TIME" => "3600",
										"MENU_CACHE_USE_GROUPS" => "Y",
										"MENU_CACHE_GET_VARS" => array(
										),
										"MAX_LEVEL" => "1",
										"CHILD_MENU_TYPE" => "left",
										"USE_EXT" => "N",
										"DELAY" => "N",
										"ALLOW_MULTI_SELECT" => "N",
										"COMPONENT_TEMPLATE" => "bottom_menu_mob2"
									),
									false
								);?>
                                
                            </div>
                            <div class="footer-nav _type3">
                                <?$APPLICATION->IncludeComponent(
									"bitrix:menu", 
									"bottom_menu_mob3", 
									array(
										"ROOT_MENU_TYPE" => "urist",
										"MENU_CACHE_TYPE" => "N",
										"MENU_CACHE_TIME" => "3600",
										"MENU_CACHE_USE_GROUPS" => "Y",
										"MENU_CACHE_GET_VARS" => array(
										),
										"MAX_LEVEL" => "1",
										"CHILD_MENU_TYPE" => "left",
										"USE_EXT" => "N",
										"DELAY" => "N",
										"ALLOW_MULTI_SELECT" => "N",
										"COMPONENT_TEMPLATE" => "bottom_menu_mob3"
									),
									false
								);?>
                            </div>
                        </div>
                    </div>
                    <div class="footer__pay">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/img/pay.png" alt="">
                    </div>

                    <div class="footer-info">
                    	<div class="footer-info__item">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
													"AREA_FILE_SHOW" => "file",
													"PATH" => "/includes/copyright.php",
													"EDIT_TEMPLATE" => ""
													),
													false
												);?>
												</div>
                        <div class="footer-info__item">
		                        <? if ($APPLICATION->GetCurPage(false) === '/'): ?> 
														Поисковое <a href="https://contactgroup.ru/">продвижение сайта</a>: contactgroup.ru
														<? else: ?> 
														<noindex>Поисковое <a rel="nofollow" href="https://contactgroup.ru/">продвижение сайта</a>: contactgroup.ru</noindex>
														 <?endif;?>
												 </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="<?= SITE_TEMPLATE_PATH ?>/js/libs.min.js"></script>
    <script src="<?= SITE_TEMPLATE_PATH ?>/js/main.min.js"></script>

    <!-- BEGIN JIVOSITE CODE {literal} -->
		<script type='text/javascript'>
		(function(){ var widget_id = 'RFbRyH0cF0';
		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
		<!-- {/literal} END JIVOSITE CODE -->

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
		   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		   ym(12720001, "init", {
		        clickmap:true,
		        trackLinks:true,
		        accurateTrackBounce:true
		   });
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/12720001" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		<!-- HoverSignal -->
		<script type="text/javascript" >
		(function (d, w) {
		var n = d.getElementsByTagName("script")[0],
		s = d.createElement("script"),
		f = function () { n.parentNode.insertBefore(s, n); };
		s.type = "text/javascript";
		s.async = true;
		s.src = "https://app.hoversignal.com/Api/SignalScript/9c16b8a0-b4de-4d3e-8309-c0e67d0ed573";
		if (w.opera == "[object Opera]") {
		d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
		})(document, window);
		</script>
		<!-- /Hoversignal -->
</body>
</html>