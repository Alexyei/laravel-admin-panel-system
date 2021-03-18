// отправка alert-уведомлений (view-message) при редактировании и добавлении постов

$(document).ready(function () {
    $('form').submit(function (event) {
        if (this.dataset.noajax)
            return;
        var json;
        event.preventDefault();
        let btn = document.activeElement;
        btn.classList.toggle("load");
        btn.setAttribute("disabled", true);
        if (btn.querySelector(".fa-spin"))
            btn.querySelector(".fa-spin").classList.toggle("del");
        if (btn.querySelector(".text"))
            btn.querySelector(".text").classList.toggle("del");
        // setTimeout(() => {
        console.log("start ajax");
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {

                    console.log("success ajax");
                    console.log(result);
                    // json = jQuery.parseJSON(result);
                    // где используеться json.url? в каких экшенах
                    // view location
                    // if (json.url) {
                    //     window.location.href = '/' + json.url;
                    // } else {
                        // alert(json.status + ' - ' + json.message);
                    if (result.message)
                        modalAlertNotification(result.message,result.status);
                    if (result.redirect)
                            window.location.href = result.redirect;
                    // }
                },
                error: function (result){
                    result = result.responseJSON;
                    console.log(result);
                    console.log(result.status);
                    // ошибки валидации
                    if (result.errors)

                        modalAlertNotification(Object.values(result.errors)[0][0],"error");
                    else
                        modalAlertNotification(result.message,result.status);
                }
            }).always(function(){
				btn.classList.toggle("load");
				btn.removeAttribute("disabled");
				if (btn.querySelector(".fa-spin"))
					btn.querySelector(".fa-spin").classList.toggle("del");
				if (btn.querySelector(".text"))
					btn.querySelector(".text").classList.toggle("del");
			});


        // }, 3000);
    });
});
