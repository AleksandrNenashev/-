function ajaxpostshow(urlres, datares, wherecontent){
	$.ajax({
		type: "POST",
		url: urlres,
		data: datares,
		dataType: "html",
		success: function(fillter){
			$(wherecontent).html(fillter);
		}
	});
}
function ajax_init(){
	$(".addtobasket").on("click", function(){
		var addbasketid = $(this).attr('id');
		ajaxpostshow("/includes/small_basket.php", addbasketid, ".header__cart" );
		return false;
	});
	$(".formsubmit").on("click", function(){
		var formsubscrube = $(this).parents("form").serialize(),
			target = $(this).data('target'),
			block = $(this).data('block');
		formsubscrube = formsubscrube + '&action=ajax';
		ajaxpostshow(target, formsubscrube, block);
		return false;
	});
}
$(document).ready(function(){
	ajax_init();
});
function ajax_init2(){
	$(".addtobasket2").on("click", function(){
		var addbasketid = $(this).attr('id');
		ajaxpostshow("/includes/small_basket.php", addbasketid, ".header__cart" );
		return false;
	});
}
function ajax_init3(){
	$(".addtobasket3").on("click", function(){
		var addbasketid = $(this).attr('id');
		ajaxpostshow("/includes/small_basket.php", addbasketid, ".header__cart" );
		return false;
	});
}
function ajax_init4(){
	$(".addtobasket4").on("click", function(){
		var addbasketid = $(this).attr('id');
		ajaxpostshow("/includes/small_basket.php", addbasketid, ".header__cart" );
		return false;
	});
}
$(document).ready(function(){
	ajax_init4();
});