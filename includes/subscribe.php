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




<?if($idsubrscr){?>
	<div class="subscribe subscribe_finish">
		<div class="subscribe__in">
			<form>
				<i class="subscribe__icon"></i>
				<span class="subscribe__text">Спасибо! Вы подписаны на рассылку новостей.</span>
			</form>
		</div>
	</div>
<?}else{?>
	<div class="subscribe">
		<div class="subscribe__in">
			<form>
				<i class="subscribe__icon"></i>
				<span class="subscribe__text">Подпишись на новости узнай о скидке первым.</span>
				<input class="subscribe__input subscribe__email js-subscribe-input" type="email" placeholder="@" required name="email" value="<?=$_POST['email']?>">
				<input class="subscribe__input js-subscribe-input" type="text" placeholder="Ваше имя" name="name" value="<?=$_POST['name']?>">
				<button class="subscribe__btn" type="submit">Подписаться</button>
			</form>
		</div>
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
		$('.subscribe__btn').on('click', function(){
			var post = $(this).parents('form').serialize();
			post = post + '&ajax=y';
			ajax_subscr('/includes/subscribe.php', post, '.subscribe_ajax');
			return false;
		});
	</script>
<?}?>