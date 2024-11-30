<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");



$res_display_properties_descr = CIBlock::GetProperties(2, Array(), Array());
while($res_display_properties_descr_arr = $res_display_properties_descr->Fetch()){
    $display_properties_descr[$res_display_properties_descr_arr['CODE']] = $res_display_properties_descr_arr['NAME'];
}
if(!empty($arParams['OFFERS_PROPERTY_CODE'])){
	$display_properties = $arParams['OFFERS_PROPERTY_CODE'];
} else {
	$display_properties = $_POST['DISPLAY_PROPERTIES'];
}
foreach($display_properties as $dis_prop){
	$for_post_display_properties .= '<input type="hidden" name="DISPLAY_PROPERTIES[]" value="'.$dis_prop.'">';
}


if(!empty($arParams['OFFERS_PROPERTY_CODE'])){
	$parent_id = $id_tovara;
} else {
	$parent_id = $_POST['PARENT_ID'];
}

$arSelect = Array("ID", "NAME", "CATALOG_GROUP_".$_SESSION['region_price_id'], "PROPERTY_CML2_LINK");
foreach($display_properties as $dis_prop){
	$arSelect[] = 'PROPERTY_'.$dis_prop;
}

//here
if(!empty($_GET['prod'])){
	$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $parent_id, "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0, "ID" => $_GET['prod']);
	$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		foreach($display_properties as $prop){
			$_POST['SKU'][$prop] = $arFields['PROPERTY_'.$prop.'_VALUE'];
		}
	}
	$_POST['CLICKED'] = $display_properties[count($display_properties)-1];
//echo '<pre style="display:block;">'; print_r($_POST); echo '</pre>';
}




$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $parent_id, "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0);
$res = CIBlockElement::GetList(array("CATALOG_PRICE_".$_SESSION['region_price_id'] => 'ASC'), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arSku[] = $arFields;
}
foreach($arSku as $sku_el){
	foreach($display_properties as $dis_prop){
		$prop_name = 'PROPERTY_'.$dis_prop.'_VALUE';
		if(!empty($sku_el[$prop_name])){
			$skuPropertyEnum[$dis_prop][] = $sku_el[$prop_name];
		}
	}
}
foreach($skuPropertyEnum as $k => &$val){
	$val = array_unique($val);
}

foreach($display_properties as $k => $dis_prop){
	if(!empty($skuPropertyEnum[$dis_prop])){
		$tester[] = $dis_prop;
	}
}
$display_properties = $tester;


//фильтрованный результат
if(!empty($_POST)){
	$display_properties_flip = array_flip($display_properties);
	$arFilter2 = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $parent_id, "!CATALOG_PRICE_".$_SESSION['region_price_id'] => 0);
	unset($key);
	unset($val);
	foreach($_POST['SKU'] as $key => $val){
		unset($prop_name);
		$prop_name = 'PROPERTY_'.$key;
		$arFilter2[$prop_name] = $val;

		unset($res);
		$res = CIBlockElement::GetList(array(), $arFilter2, false, false, $arSelect);
		unset($arSku_cur);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$arSku_cur[] = $arFields;
		}
		foreach($arSku_cur as $sku_el){
			foreach($display_properties as $k => $dis_prop){
				$prop_name = 'PROPERTY_'.$dis_prop.'_VALUE';
				if(!empty($sku_el[$prop_name])){
					$name_filtered_mass1 = $display_properties_flip[$key];
					$name_filtered_mass2 = $name_filtered_mass1+1;
					$name_filtered_mass3 = $display_properties[$name_filtered_mass2];
					$skuPropertyEnum_cur[$name_filtered_mass3][$dis_prop][] = $sku_el[$prop_name];
				}
			}
		}
		foreach($skuPropertyEnum_cur as &$val1){
			foreach($val1 as $k => &$val2){
				$val2 = array_unique($val2);
			}
		}
		//if($_POST['CLICKED'] == $key){
		//	break;
		//}
	}
}




foreach($display_properties as $k => $dis_prop){
	$display_properties_activated[$dis_prop] = 'Y';
	if(empty($_POST['CLICKED'])){
		break;
	} elseif($_POST['CLICKED'] == $dis_prop) {
		$display_properties_activated[$display_properties[$k+1]] = 'Y';
		break;
	}
}
$display_properties_filtered = $display_properties_activated;
$display_properties_filtered[$display_properties[0]] = 'N';

foreach($skuPropertyEnum['COLOR'] as $color){
	$fil[] = $p['VALUE'];
}
$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE");

//echo "<pre>";print_r($fil);echo "</pre>";
$arFilter = Array("IBLOCK_ID"=>IntVal(5), "ACTIVE"=>"Y", 'NAME' => $fil);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$file = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width'=>'45', 'height'=>'45'), BX_RESIZE_IMAGE_PROPORTIONAL, false);
	$res_colors[$arFields['NAME']] = $file['src'];
}
//echo "<pre>";print_r($res_colors);echo "</pre>";

?>


<div class="prod__head">
	<div class="prod__meta disabled">
<!--
		<div class="prod__state is-available">В наличии</div>
		<div class="prod__state is-order">Под заказ</div>
-->
	</div>
<script>
	 $('li.additional').remove();
</script>
	<form class="sku_form">
		<input name="PARENT_ID" type="hidden" value="<?=$parent_id?>">
		<?=$for_post_display_properties?>
		<?
		$i = 0;
		foreach($display_properties as $key_dis_prop => $dis_prop){
			if(count($skuPropertyEnum[$dis_prop]) > 0){
				if($display_properties_filtered[$dis_prop] == 'Y' && !empty($skuPropertyEnum_cur[$dis_prop][$dis_prop])){
					$skuPropertyEnum_foreach = $skuPropertyEnum_cur[$dis_prop][$dis_prop];
				} else {
					$skuPropertyEnum_foreach = $skuPropertyEnum[$dis_prop];
				}
				?>
<?if(count($skuPropertyEnum_foreach) == 1 && $dis_prop != 'COLOR'){

	?>
	<input type="hidden" name="SKU[<?=$dis_prop?>]" value="<?=$skuPropertyEnum_foreach[0]?>">
	<input type="hidden" name="HIDDEN" value="<?=$dis_prop?>">


	<?
	$k = array_search($dis_prop, $display_properties);
	if($display_properties_activated[$display_properties[$k]] == 'Y'){
		$display_properties_activated[$display_properties[$k+1]] = 'Y';
		$display_properties_filtered[$display_properties[$k+1]] = 'Y';
	}
	?>
	<script>
		$( document ).ready(function() {
			var additional = '<li class="additional"><strong><?=$display_properties_descr[$dis_prop]?></strong><span><?=$skuPropertyEnum_foreach[0]?></span></li>';
			var left = $('ul.prod-param_left li').length,
				right = $('ul.prod-param_right li').length;
			if(right > left){
				$('.prod-param_left').append(additional);
			} else {
				$('.prod-param_right').append(additional);
			}
		});
	</script>
<?} else {

				$i++;
?>
				<div class="prod__param">
					<div class="prod__param-title"><span><?=$i?>.</span><?=$display_properties_descr[$dis_prop]?>:</div>
					<div class="prod__item">
						<?if($dis_prop != 'COLOR'){?>
							<?if(count($skuPropertyEnum_foreach) < 3){?>
								<?foreach($skuPropertyEnum_foreach as $propEnum){?>
									<label class="radio">
										<input class="sku" value="<?=$propEnum?>" type="radio" name="SKU[<?=$dis_prop?>]" data-name="<?=$dis_prop?>" <?if($_POST['SKU'][$dis_prop] == $propEnum){echo 'checked';}?> <?if($display_properties_activated[$dis_prop] != 'Y'){echo 'disabled';}?>>
										<i></i>
										<strong><?=$propEnum?></strong>
									</label>
								<?}?>
							<?} else {?>
								<div class="select">
									<select class="sku" name="SKU[<?=$dis_prop?>]" data-name="<?=$dis_prop?>" <?if($display_properties_activated[$dis_prop] != 'Y'){echo 'disabled';}?>>
										<option value="" <?if(!empty($_POST)){?> disabled<?}?>>Выберите</option>
										<?foreach($skuPropertyEnum_foreach as $propEnum){?>
											<option value="<?=$propEnum?>" <?if($_POST['SKU'][$dis_prop] == $propEnum){echo 'selected="selected"';}?>><?=$propEnum?></option>
										<?}?>
									</select>
								</div>
							<?}?>
						<?} else {?>
							<div class="js-slider-color">
								<?foreach($skuPropertyEnum_foreach as $key => $propEnum)
								{
										$active = "";
										if($_POST['SKU'][$dis_prop] == $propEnum){$active = 'is-active';}
								?>
									<div class="color js-color js-tooltip-img-key <?=$active?>" data-value="<?=$propEnum?>" data-title="
										<div class='tooltip__with-img'>
											<div class='tooltip__img'><img src='<?=$res_colors[$propEnum]?>' alt=''></div>
											<?=$propEnum?>
										</div>
									">
										<?
										//echo $propEnum."<br >";
										//echo "!$res_colors[$propEnum]!";
										?>
										<img src="<?=$res_colors[$propEnum]?>" alt="">
									</div>
								<?}?>
								<input class="sku" type="hidden" name="SKU[<?=$dis_prop?>]" value="">
							</div>
						<?}?>
					</div>
				</div>

<?}?>
			<?}?>
		<?}?>
	</form>
</div>
<div class="prod__price">
	<?if(!empty($_GET['prod'])){
		//and-here
		$_POST['PARENT_ID'] = $parent_id;
		require_once($_SERVER["DOCUMENT_ROOT"]."/catalog/getSkuProdPrice.php");
	} else {?>
		<?if($arResult['MIN_PRICE2']['DISCOUNT_DIFF_PERCENT'] > 0){?><!-- 444 -->
			<div class="old-price">Старая  цена: <span><?=$arResult['MIN_PRICE2']['PRINT_VALUE_NOVAT']?></span></div>
		<?}?>
		<?if(!empty($arResult['MIN_PRICE2']['PRINT_DISCOUNT_VALUE'])){?>
            <meta itemprop="price" content = "<?=(int)$arResult['MIN_PRICE2']['VALUE_NOVAT'];?>">
			<div class="prod__sum">от <?=$arResult['MIN_PRICE2']['PRINT_DISCOUNT_VALUE'];?></div>
		<?}?>
		<a href="#" class="btn btn_green btn_basket" disabled>В  корзину</a>
	<!--
		<div><a href="js-popup-buy" class="buy-click js-popup-link">Быстро купить в 1 клик</a></div>
	-->
	<?}?>
</div><? if($arResult['PROPERTIES']['PRICE_LOWER']['VALUE'] == 'да'){?>
	<a  title="Заказать звонок" class=" btn_new_red" href="#form-id1" >Заказать звонок</a>
	 
	 <?}?> 
<script>
	$( document ).ready(function(){
		var el = $( ".prod__param .color.js-color:first-child" );
		//alert(el.html());
		el.click();
	});
</script>
<script>
function ajaxpostshow(urlres, datares, wherecontent, clicked = false){
       $.ajax({
           type: "POST",
           url: urlres,
           data: datares,
           dataType: "html",
           beforeSend: function(){
                var elementheight = $(wherecontent).height();
                $(wherecontent).prepend('');
                $('.ajaxloader').css('height', elementheight);
                $('.ajaxloader').prepend('');
            },
           success: function(fillter){
               $(wherecontent).html(fillter);
               if ($('select.sku[data-name=MATERIAL]').length > 0 && clicked == 'SLEEP_SIZE'){
                   $('select.sku[data-name=MATERIAL] option:nth-child(2)').attr('selected', true);
                   var array = $('select.sku[data-name=MATERIAL]').parents('form').serialize();
                   array = array + '&CLICKED=MATERIAL';
                   ajaxpostshow("/catalog/getSkuProd.php", array, ".prod");
               }
               if ($('.js-color').length > 0 && wherecontent != '.prod__price'){
                   $('.js-color').eq(0).trigger('click');
                   return false;
               }
           }
      });
}

$(".sku").on("change", function(){
	var array = $(this).parents('form').serialize();
	array = array + '&CLICKED=' + $(this).data('name');
	ajaxpostshow("/catalog/getSkuProd.php", array, ".prod", $(this).data('name'));
	return false;
});
// $('.js-slider-color').slick({
// 	slidesToShow: 3,
// 	infinite: false,
// 	speed: 300,
// 	touchMove: true,
// 	slidesToScroll: 3
// });
<?if($display_properties_activated['COLOR'] == 'Y'){?>
  $(".js-color").on("click", function() {
	var input_value = $(this).data('value');
  	$(this).parents(".js-slider-color").find(".js-color").removeClass("is-active");
	$(this).parents(".js-slider-color").find("input").val(input_value);
        $(this).addClass("is-active");

	var array = $(this).parents('form').serialize();
	array = array + '&CLICKED=' + $(this).data('name');
	ajaxpostshow("/catalog/getSkuProdPrice.php", array, ".prod__price" );

        return false;
  });
<?} else {
	$skuPropertyEnum_keys = array_keys($skuPropertyEnum);
	$skuPropertyEnum_lastkey = array_pop($skuPropertyEnum_keys);
	if($_POST['CLICKED'] == $skuPropertyEnum_lastkey){?>
		var array = $('.sku_form').serialize();
		array = array + '&CLICKED=' + '<?=$_POST['CLICKED']?>';
		ajaxpostshow("/catalog/getSkuProdPrice.php", array, ".prod__price" );
    <?}
}?>

<?if(empty($_POST)){?>
	$("body").prepend( '<div class="tooltip js-tooltip"><div class="tooltip__in"></div></div>' );
	$("body").prepend( '<div class="tooltip js-tooltip-img has-img"><div class="tooltip__in"></div></div>' );
<?}?>
	var tooltip = $(".js-tooltip");
	var tooltip_img = $(".js-tooltip-img");
	$(".js-tooltip-key").hover(
		function(){

			var left = $(this).offset().left;
			var bottom = $(window).height() - $(this).offset().top;
			var tooltip_html = $(this).attr("data-title");
			tooltip.css({
				left: left,
				bottom: bottom-8 
			});
			tooltip.find(".tooltip__in").html(tooltip_html).fadeIn("fast");
			tooltip.fadeIn("fast");
		},
		function() {
			tooltip.hide();
		}
	);

	$(".js-tooltip-img-key").hover(
		function(){
			//tooltip.addClass("has-img");
			var left = $(this).offset().left;
			var bottom = $(window).height() - $(this).offset().top;
			var tooltip_html = $(this).attr("data-title");
			tooltip_img.css({
				left: left,
				bottom: bottom
			});
			tooltip_img.find(".tooltip__in").html(tooltip_html).fadeIn("fast");
			tooltip_img.fadeIn("fast");
		},
		function() {
			tooltip_img.hide();
		}
	);
	tooltip.hover(
		function(){
			tooltip.show();
		},
		function() {
			tooltip.hide(); 
		}
	);
	tooltip_img.hover(
		function(){
			tooltip_img.show();
		},
		function() {
			tooltip_img.hide(); 
		}
	);

</script>
















<?//echo '<pre style="display:block;">'; print_r($display_properties); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($skuPropertyEnum); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($skuPropertyEnum_cur); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($arSku); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($_POST); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($display_properties_activated); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($display_properties_filtered); echo '</pre>';?>
<?//echo '<pre style="display:block;">'; print_r($skuPropertyEnum_foreach); echo '</pre>';?>
