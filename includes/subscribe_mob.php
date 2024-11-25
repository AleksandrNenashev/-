<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("subscribe");
global $USER;
if ($USER->IsAuthorized()){
    $USER_ID = $USER->GetID();
}
?>
<?php
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
<?php
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

<?php if($idsubrscr): ?>
    <div class="subscribe m-section">
        <div class="container">
            <div class="subscribe-form">
                <div class="subscribe-form__top">
                    <div class="subscribe-form__title text21 text14-mob bold-text font2">
                        Спасибо! Вы подписаны на рассылку новостей.
                    </div>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/mail.png" alt="" class="subscribe-form__img">
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="subscribe m-section">
        <div class="container">
            <form action="" class="subscribe-form">
                <div class="subscribe-form__top">
                    <div class="subscribe-form__title text21 text14-mob bold-text font2">
                        Подпишись на новости узнай о скидке первым
                    </div>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/mail.png" alt="" class="subscribe-form__img">
                </div>
                <div class="subscribe-form__bottom">
                    <div class="subscribe-form__field">
                        <input type="text" placeholder="Ваше имя" name="name" value="<?=$_POST['name']?>" required>
                        <input type="email" placeholder="@" name="email" value="<?=$_POST['email']?>" required>
                    </div>
                    <button class="subscribe-form__btn m-btn" type="submit">
                        <span>Подписаться</span>
                    </button>
                </div>
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

    $('.subscribe-form__btn').on('click', function(event){
        event.preventDefault(); // Отменяем стандартное поведение формы (перезагрузку страницы)
        
        var post = $(this).parents('form').serialize();
        post = post + '&ajax=y';
        ajax_subscr('/includes/subscribe.php', post, '.subscribe_ajax');
    });
</script>

<?php endif; ?>
