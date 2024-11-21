<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("subscribe");
global $USER;
if ($USER->IsAuthorized()){
	$USER_ID = $USER->GetID();
}
?>
<?
if($_POST['ajax'] == 'y' && !empty($_POST['email'])){
	$RUB_ID = array();
	$rub = CRubric::GetList(array(), array("ACTIVE"=>"Y"));
	while($rub->ExtractFields("r_")){
		$RUB_ID = array($r_ID);
	}

	$subscr = new CSubscription;
	$arFields = Array(
		"USER_ID" => ($USER->IsAuthorized()? $USER->GetID():false),
		"FORMAT" => "html/text",
		"EMAIL" => $_POST['email'],
		"ACTIVE" => "Y",
		"RUB_ID" => $RUB_ID,
		"SEND_CONFIRM" => "N"
	);
	$idsubrscr = $subscr->Add($arFields);

	if(!empty($idsubrscr)){
		$arEventFields = array(
		    "EMAIL" => $_POST['email'],
		    "NAME" => ', '.$_POST['name']
		);
		CEvent::Send("SUBSCR", "s1", $arEventFields, "N");
	}

	$strWarning .= "<sup>".$subscr->LAST_ERROR."</sup>";
}
if($_POST['ajax'] == 'y' && empty($_POST['email'])){
	$err = '<sup>Заполните e-mail</sup>';
}
?>
<?
if($idsubrscr && $USER->IsAuthorized()){
	$rsUser = CUser::GetByID($USER_ID);
	$arUser = $rsUser->Fetch();
	$cur_subscr = $arUser['UF_SUBSCR'];

	if($arUser['EMAIL'] != $_POST['email']){
		$cur_subscr[] = $_POST['email'];
	
		$user = new CUser;
		$fields = Array(
			"UF_SUBSCR" => $cur_subscr,
		);
		$user->Update($USER_ID, $fields);
	}
}
?>
<div class="email-subscribe">
	<div class="email-subscribe__title">подписаться на новости</div>
	<form>
		<label class="field" for="firstname">
			<span class="field__el">
				<input type="text" name="name" placeholder="Ваше имя" value="<?=$_POST['name']?>">
			</span>
		</label>
		<label class="field" for="email2">
			<span class="field__el">
				<input type="email" name="email" placeholder="E-mail" required value="<?=$_POST['email']?>">
				<sup style="color:red"><?=$err?><?=$strWarning?></sup>
				<?if($idsubrscr){?>
					<sup style="color:green">Спасибо! Вы подписаны на рассылку новостей.</sup>
				<?}?>
			</span>
		</label>
		<button type="submit" class="btn btn_orange btn_arr subscribe__btn2">Подписаться</button>
	</form>
</div>
<script>
	function ajax_subscr(urlres, datares, wherecontent){
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
	$('.subscribe__btn2').on('click', function(){
		var post = $(this).parents('form').serialize();
		post = post + '&ajax=y';
		ajax_subscr('/includes/subscribe2.php', post, '.subscribe_ajax2');
		return false;
	});
</script>