function modalAlertNotification(message, status="error",redirect ="", header="") {

    //$('.modal .title').html(status);
    //$('.modal .desc').html(message);

    //$('.modal').css({'visibility': 'visible', 'opacity': '1'});
    // console.log(100);
    let icon;
    let title;
    switch(status){
        case "info": icon="<i class=\"fas fa-info-circle\"></i>";title="Информация";break;
        case "warning": icon="<i class=\"fas fa-exclamation-triangle\"></i>";title="Предупреждение";break;
        case "success": icon="<i class=\"fas fa-check-circle\"></i>";title="Успех!";break;
        case "error":
        default: icon="<i class=\"fas fa-times-circle\"></i>";title="Ошибка!";break;
    }
    if (header) title=header;

    $(".popup .icon").html(icon);
    $(".popup .title").html(title);
    $(".popup .description").html(message);

    document.querySelector(".bg-modal-popup").classList.toggle("popup-modal-visible");
    document.querySelector(".popup").classList.toggle("active");


    return new Promise(function (resolve, reject) {
        // $('.modal .modal-box .icon i').on('click', function () {
        //     console.log("close");
        //     $('.modal').css({'visibility': 'hidden', 'opacity': '0'});
        //     resolve();
        // });

        $("#dismiss-popup-btn").off('click').on('click',function(){
            console.log(200);
            // console.log(300);
            document.querySelector(".bg-modal-popup").classList.toggle("popup-modal-visible");
            document.querySelector(".popup").classList.toggle("active");
            if(redirect)
                window.location.href = redirect;
            resolve();
        });
    });

}
