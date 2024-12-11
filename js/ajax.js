function ajaxpostshow(urlres, datares, wherecontent) {
    $.ajax({
        type: "POST",
        url: urlres,
        data: datares, // Здесь объект, например { ajaxaddid: 123 }
        dataType: "html",
        success: function (response) {
            console.log("Ответ сервера:", response); // Лог ответа сервера
            $(wherecontent).html(response); // Вставляем ответ в нужный блок
        },
        error: function (xhr, status, error) {
            console.error("Ошибка AJAX:", status, error); // Лог ошибок, если что-то не так
        }
    });
}

$(".addtobasket").on("click", function () {
    var addbasketid = $(this).attr('id').replace('add_', ''); // Удаляем префикс "add_"
    ajaxpostshow("/includes/small_basket.php", { ajaxaddid: addbasketid }, ".cart-counter"); // Селектор .cart-counter
    console.log("Кнопка нажата ID товара:", addbasketid); // Проверяем ID товара
    return false;
});

function ajax_init(selector) {
    $(selector).on("click", function () {
        var addbasketid = $(this).attr('id').replace('add_', ''); // Извлечение ID
        ajaxpostshow("/includes/small_basket.php", { ajaxaddid: addbasketid }, ".cart-counter"); // Селектор .cart-counter
        return false;
    });
}

$(document).ready(function () {
    ajax_init(".addtobasket"); // Инициализация для всех кнопок с классом addtobasket
});
