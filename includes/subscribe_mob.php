<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("subscribe");
global $USER;

if ($USER->IsAuthorized()) {
    $USER_ID = $USER->GetID();
}

$response = '';

if ($_POST['ajax'] === 'y') {
    if (!empty($_POST['email'])) {
        $RUB_ID = [];
        $rub = CRubric::GetList([], ["ACTIVE" => "Y"]);
        while ($rub->ExtractFields("r_")) {
            $RUB_ID[] = $r_ID;
        }

        $subscr = new CSubscription;
        $arFields = [
            "USER_ID" => ($USER->IsAuthorized() ? $USER->GetID() : false),
            "FORMAT" => "html/text",
            "EMAIL" => $_POST['email'],
            "ACTIVE" => "Y",
            "RUB_ID" => $RUB_ID,
            "SEND_CONFIRM" => "N"
        ];
        
        $idsubrscr = $subscr->Add($arFields);

        if (!empty($idsubrscr)) {
            $arEventFields = [
                "EMAIL" => $_POST['email'],
                "NAME" => $_POST['name']
            ];
            CEvent::Send("SUBSCR", "s1", $arEventFields, "N");
            $response = "<div class=\"subscribe m-section\"> 
                <div class=\"container\"> 
                    <form action=\"\" class=\"subscribe-form\"> 
                        <div class=\"subscribe-form__top\"> 
                            <div class=\"subscribe-form__title text21 text14-mob bold-text font2\"> 
                                Спасибо! Вы подписаны на рассылку новостей. 
                            </div> 
                            <img src=\"" . SITE_TEMPLATE_PATH . "/img/mail.png\" alt=\"\" class=\"subscribe-form__img\"> 
                        </div> 
                    </form> 
                </div> 
            </div>";
        } else {
            $response = "<div class=\"subscribe-form__message error\">Ошибка: " . $subscr->LAST_ERROR . "</div>";
        }
    } else {
        $response = "<div class=\"subscribe-form__message error\">Пожалуйста, заполните e-mail</div>";
    }

    if ($idsubrscr && $USER->IsAuthorized()) {
        $rsUser = CUser::GetByID($USER_ID);
        $arUser = $rsUser->Fetch();
        $cur_subscr = $arUser['UF_SUBSCR'];

        if ($arUser['EMAIL'] !== $_POST['email']) {
            $cur_subscr[] = $_POST['email'];

            $user = new CUser;
            $fields = [
                "UF_SUBSCR" => $cur_subscr
            ];
            $user->Update($USER_ID, $fields);
        }
    }

    echo $response;
    exit;
}
?>

<div class="subscribe_ajax">
    <div class="subscribe m-section">
        <div class="container">
            <form action="" class="subscribe-form" method="post">
                <div class="subscribe-form__top">
                    <div class="subscribe-form__title text21 text14-mob bold-text font2">
                        Подпишись на новости узнай о скидке первым
                    </div>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/mail.png" alt="" class="subscribe-form__img">
                </div>
                <div class="subscribe-form__bottom">
                    <div class="subscribe-form__field">
                        <input type="text" name="name" placeholder="Ваше имя" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>
                    <div class="subscribe-form__field">
                        <input type="email" name="email" placeholder="Ваш e-mail" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <button type="submit" class="subscribe-form__btn m-btn">
                        <span>Подписаться</span>
                    </button>
                </div>
                <input type="hidden" name="ajax" value="y">
            </form>
            <div class="subscribe-form__response"></div>
        </div>
    </div>
</div>

<script>
    document.querySelector('.subscribe-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('/includes/subscribe_mob.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            document.querySelector('.subscribe_ajax').innerHTML = html;
        })
        .catch(error => {
            document.querySelector('.subscribe_ajax').innerHTML = `<div class=\"subscribe-form__message error\">Произошла ошибка, попробуйте позже.</div>`;
        });
    });
</script>