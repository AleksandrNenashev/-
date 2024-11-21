<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

function renderMobileMenu($menuItems, $parentPath = '')
{
    foreach ($menuItems as $menuItem) {
        // Формируем путь как "Каталог/Гостиная/..."
        $currentPath = $parentPath ? $parentPath . '/' . $menuItem['TEXT'] : $menuItem['TEXT'];
        ?>
        <div class="menu-item">
            <div class="menu-item__show <?= !empty($menuItem['CHILDS']) ? '_open-sub-menu' : '' ?>">
                <a href="<?= $menuItem['LINK'] ?>"><?= $menuItem['TEXT'] ?></a>
            </div>
            <?php if (!empty($menuItem['CHILDS'])) { ?>
                <div class="sub-menu">
                    <div class="sub-menu__back">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/img/arrow-left.svg" alt="">
                        <span>Назад</span>
                    </div>
                    <div class="sub-menu__title">
                        Каталог/<?= $currentPath ?>
                    </div>
                    <div class="mob-menu__items">
                        <?php renderMobileMenu($menuItem['CHILDS'], $currentPath); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php }
}
?>

<div class="mob-menu">
                <div class="mob-menu__bg _toggle-menu"></div>
					<div class="mob-menu__inner">
						<div class="mob-menu__title">
							Каталог
						</div>
						<div class="mob-menu__items">
							<div class="mobile-menu">
								<?php renderMobileMenu($arResult); ?>
							</div>
						</div>
					</div>
</div>             
                
<?//echo '<pre style="display:none;">'; print_r($arResult); echo '</pre>';?>