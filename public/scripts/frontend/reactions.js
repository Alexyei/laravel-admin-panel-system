$(document).ready(function () {
    //let commentCount = Number($('.comment-count').first().text())
    // console.log(commentCount);
    // $("a[data-reaction-type]").on('click', function () {

    // on навешивает обработчики даже на новые элементы, созданные с помощью AJAX
    $(document).on('click',"a[data-reaction-type]", function () {
        if ($(this).closest(".comment-header").hasClass("not-allowed")){
            modalAlertNotification('Войдите, чтобы оставлять оценки','info')
            return false;
        }

        let comment = $(this).data("commentId");
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
                url: '/reaction/',
                method: 'POST',
                dataType: 'text',
                data: {
                    comment: comment,
                    // isReply: isReply,
                    type: type
                }, success: function (response) {

                    console.log('success reaction answer');

                    json = jQuery.parseJSON(response);

                    clicked_button.toggleClass("active")
                    clicked_button.siblings(".active").removeClass("active");
                    clicked_button.siblings(".reaction-up-count").text(json.like);
                    clicked_button.siblings(".reaction-down-count").text(json.dislike);

                },
                error: function (data) {
                    // console.log(data);
                    json = jQuery.parseJSON(data.responseText);
                    modalAlertNotification(json.message,json.status);
                }
            });
        // } else {
        //     alert('Длина комментария должна быть от 5 до 10000 символов');
        // }
        return false;
    });
});
