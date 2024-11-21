<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin('');
?>
<?$sum = 0;
$quantity = 0;
$list = '';
foreach($arResult['ITEMS'] as &$arItem){
	if(!empty($arItem['res'])){
		$find = $arItem['res']['PROPERTY_CML2_LINK_VALUE'];
	} else {
		$find = $arItem['PRODUCT_ID'];
	}
	$res = CIBlockElement::GetByID($find);
	if($ar_res = $res->GetNext()){
		$pic = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
		if($ar_res['IBLOCK_ID'] == 4){
			$url = '';
		} else {
			$url = 'href="'.$ar_res['DETAIL_PAGE_URL'].'"';
		}
	}

	$list .= '<div class="cart-item"><a '.$url.' class="cart-item__img"><img src="'.$pic.'" width="62" alt=""></a><div class="cart-item__info"><a '.$url.'>'.$arItem['NAME'].'</a><br /><span>'.$arItem['PRICE_FORMATED'].'</span></div></div>';
	$sum = $sum + ($arItem['PRICE']*$arItem['QUANTITY']);
	$quantity = $quantity + $arItem['QUANTITY'];
}?>


<div class="header__cart-in">
	<a href="<?=$arParams["PATH_TO_BASKET"]?>">В корзине <?=$quantity?> товаров</a>
	<!--<div>на сумму <?=number_format($sum, 0, '', ' ');?> <span class="rub">Р<span>уб.</span></span></div>-->
	<div>на сумму <?=CurrencyFormat($sum, 'RUB');?></div>
</div>
<div class="header__cart-drop">
	<div class="header__cart-list">
		<div class="header__cart-scroll">
			<?=$list?>
		</div>
	</div>
	<div class="header__cart-btn">
		<div class="header__cart-price">
			Итого: <span><?=CurrencyFormat($sum, 'RUB');?>
		</div>
		<form method="get" action="<?= $arParams["PATH_TO_ORDER"] ?>">
			<input class="btn btn_green" type="submit" value="Оформить заказ">
		</form>
		<!--<a href="#" class="btn btn_green">Оформить заказ</a>
		<a href="#" class="btn btn_orange">Купить в кредит</a>-->
	</div>
</div>
<?//echo '<pre style="display:block;">'; print_r($arResult); echo '</pre>';?>








<!--
<?

if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
{
?><table class="sale_basket_small"><?
	if ($arResult["READY"]=="Y")
	{
		?><tr><td align="center"><? echo GetMessage("TSBS_READY"); ?></td></tr>
		<tr><td><ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"]; ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li>
				<?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
			?><tr><td align="center"><form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
			</form></td></tr><?
		}
		if ('' != $arParams["PATH_TO_ORDER"])
		{
			?><tr><td align="center"><form method="get" action="<?= $arParams["PATH_TO_ORDER"] ?>">
			<input type="submit" value="<?= GetMessage("TSBS_2ORDER") ?>">
			</form></td></tr><?
		}
	}
	if ($arResult["DELAY"]=="Y")
	{
		?><tr><td align="center"><?= GetMessage("TSBS_DELAY") ?></td></tr>
		<tr><td><ul>
		<?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="Y" && $v["CAN_BUY"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li>
				<?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
			?><tr><td><form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
			</form></td></tr><?
		}
	}
	if ($arResult["SUBSCRIBE"]=="Y")
	{
		?><tr><td align="center"><?= GetMessage("TSBS_SUBSCRIBE") ?></td></tr>
		<tr><td><ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?></li><?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
	}
	if ($arResult["NOTAVAIL"]=="Y")
	{
		?><tr><td align="center"><?= GetMessage("TSBS_UNAVAIL") ?></td></tr>
		<tr><td><ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="N")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li><?
			}
		}
		if (isset($v))
			unset($v);
		?></ul></td></tr><?
	}
	?></table><?
}
?>
-->
<?//echo '<pre style="display:none;">'; print_r($arResult); echo '</pre>';?>