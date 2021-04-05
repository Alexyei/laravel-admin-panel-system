$(document).ready(function () {
    //let commentCount = Number($('.comment-count').first().text())
    // console.log(commentCount);
    // $("a[data-reaction-type]").on('click', function () {

    function ajaxErrorHandler(result){
        //console.log("handler");
        //  console.log(result);
        // json = jQuery.parseJSON(data.responseText);
        // modalAlertNotification(json.message,json.status);
        result = jQuery.parseJSON(result.responseText)
        // console.log(result);
        //  console.log(result.status);
        // ошибки валидации
        if (result.errors)

            modalAlertNotification(Object.values(result.errors)[0][0],"error");
        else if (result.message)
            modalAlertNotification(result.message,result.status,result.redirect);
        else if (result.redirect)
            window.location.href = result.redirect;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // on навешивает обработчики даже на новые элементы, созданные с помощью AJAX
    $(document).on('click',"a[data-reaction-type]", function () {
        if ($(this).closest(".comment-header").hasClass("not-allowed")){
            modalAlertNotification('Войдите, чтобы оставлять оценки','info')
            return false;
        }

        let commentId = $(this).data("commentId");
        let type = $(this).data("reactionType");
        if ($(this).hasClass("active"))
            type = "un" + type;
        // console.log("reaction");


        let clicked_button = $(this);


        // console.log(comment);
        // console.log(type);
        // console.log(clicked_button);
        // return false;
        // if ([...comment].length > 5 && [...comment].length <= 10000) {
            $.ajax({
                url: '/reaction',
                method: 'POST',
                dataType: 'text',
                data: {
                    commentId: commentId,
                    // isReply: isReply,
                    type: type
                }, success: function (response) {

                    console.log('success reaction answer');

                    console.log(response);
                    json = jQuery.parseJSON(response)
                   // json = response.responseJSON;
                    clicked_button.toggleClass("active")
                    clicked_button.siblings(".active").removeClass("active");
                    console.log("TYPE:"+type);

                    clicked_button.siblings(".reaction-up-count").text(json.like);
                    clicked_button.siblings(".reaction-down-count").text(json.dislike);

                },
                error: function (result) {
                   ajaxErrorHandler(result);
                }
            });
        // } else {
        //     alert('Длина комментария должна быть от 5 до 10000 символов');
        // }
        return false;
    });
});
