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

                    console.log("success ajax")
                    json = jQuery.parseJSON(result);
                    // где используеться json.url? в каких экшенах
                    // view location
                    // if (json.url) {
                    //     window.location.href = '/' + json.url;
                    // } else {
                        // alert(json.status + ' - ' + json.message);
                        modalAlertNotification(json.message,json.status);
                        if (json.redirect)
                            window.location.href = '/' + json.redirect;
                    // }
                },
                error: function (result){
                    modalAlertNotification(Object.values(result.responseJSON.errors)[0][0],"error");
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
