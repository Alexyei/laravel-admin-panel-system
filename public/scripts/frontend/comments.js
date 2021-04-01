// document.querySelectorAll(".comment-answer").forEach(el => el.addEventListener('click', function (e) {
//     reply(this);
// }));

// document.querySelectorAll(".comment-cancel").
// forEach(el=>el.addEventListener('click',function (e){
//     $('.replyRow').hide();
// }));

function reply(caller) {
    // commentID = $(caller).attr('data-commentID');
    // console.log($(caller).dataset);
    // console.log($(caller).data("commentId"));
    // console.log($(caller).data("comment-id"));
    $("#addReply").data("parent-id", $(caller).data("commentId"));
    // console.log($("#addReply").data("parentId"));
    $(".replyRow").insertAfter($(caller));
    $('.replyRow').show();
}


$(document).ready(function () {

    // $(document).on('click', ".not-allowed a", function () {
    //     return false;
    // });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let commentCount = Number($('.comment-count').first().text())
    // console.log(commentCount);
    $("#addComment, #addReply").on('click', function () {
        // console.log(this);
        let parentId = $(this).data("parentId");
        let postId = $(this).data("postId");
        let isReply = !!parentId;
        let comment = (!isReply) ? $("#mainComment").val() : $("#replyComment").val();

        // console.log(parentId);
        // console.log(postId);
        // console.log(isReply);
        // console.log(comment);
        // console.log('/comment/'+((isReply)?'reply':'store'));


        if ([...comment].length > 4 && [...comment].length <= 10000) {
            $.ajax({
                url: '/comment/'+((isReply)?'reply':'store'),
                method: 'POST',
                dataType: 'text',
                data: {
                    comment: comment,
                    // isReply: isReply,
                    postId: postId,
                    parentId: parentId
                }, success: function (response) {

                    console.log('success answer');
                    // console.log(response);
                    // max++;
                    // $("#numComments").text(max + " Comments");
                    $('.comment-count').text(++commentCount);
                    if (!isReply) {
                        $(".userComments").prepend(response);
                        $("#mainComment").val("");
                    } else {
                        // commentID = 0;
                        $("#replyComment").val("");
                        $(".replyRow").hide();

                        let className = Array.from($(".replyRow").parent()[0].classList).filter(item => item.startsWith("reply-"))[0]
                        let nextClass = "reply-" + (Number(className.split('-')[1]) + 1);
                        let placeInDOM = $('.replyRow').parent().children('.comment-answer');

                        placeInDOM.after(response);

                        placeInDOM.next().removeClass("reply-0");
                        placeInDOM.next().addClass(nextClass);

                    }
                },
                error: function (result) {
                    // json = jQuery.parseJSON(data.responseText);
                    // modalAlertNotification(json.message,json.status);

                    result = result.responseJSON;
                    console.log(result);
                    console.log(result.status);
                    // ошибки валидации
                    if (result.errors)

                        modalAlertNotification(Object.values(result.errors)[0][0],"error");
                    else if (result.message)
                        modalAlertNotification(result.message,result.status,result.redirect);
                    else if (result.redirect)
                        window.location.href = result.redirect;
                }
            });
        } else {
            // alert('Длина комментария должна быть от 5 до 10000 символов');
            modalAlertNotification('Длина комментария должна быть от 5 до 10000 символов','info');
        }
        return false;
    });

    $(document).on('click', "a[data-action-type='delete']", function () {

        let parent = $(this).closest(".comment");

        let commentId = parent.data("commentId");

        // console.log("reaction");

        // let clicked_button = $(this);

        // console.log(comment);
        // console.log(type);
        // console.log(clicked_button);
        // return false;
        // if ([...comment].length > 5 && [...comment].length <= 10000) {
        $.ajax({
            url: '/comment/delete',
            method: 'POST',
            dataType: 'text',
            data: {
                commentId: commentId,
                // isReply: isReply,
                // type: type
            }, success: function (response) {

                console.log('success delete answer');

                parent.children('.comment-header, .comment-body, .comment-answer').remove();
                parent.prepend(response);

                // json = jQuery.parseJSON(response);
                //
                // clicked_button.toggleClass("active")
                // clicked_button.siblings(".active").removeClass("active");
                // clicked_button.siblings(".reaction-up-count").text(json.like);
                // clicked_button.siblings(".reaction-down-count").text(json.dislike);

            },
            error: function (result) {
                // json = jQuery.parseJSON(data.responseText);
                // modalAlertNotification(json.message,json.status);
                result = result.responseJSON;
                console.log(result);
                console.log(result.status);
                // ошибки валидации
                if (result.errors)

                    modalAlertNotification(Object.values(result.errors)[0][0],"error");
                else if (result.message)
                    modalAlertNotification(result.message,result.status,result.redirect);
                else if (result.redirect)
                    window.location.href = result.redirect;
            }
        });
        // } else {
        //     alert('Длина комментария должна быть от 5 до 10000 символов');
        // }
        return false;
    });


    $(".modal-close-comments").on('click', function (){
        $(".bg-modal-comments").toggleClass("modal-visible");
    });


    $(document).on('click', "a[data-action-type='complain']", function () {
        if ($(this).closest(".comment-header").hasClass("not-allowed")){
            modalAlertNotification('Войдите, чтобы отправлять предупреждения','info')
            return false;
        }
        let parent = $(this).closest(".comment");

        let comment = parent.data("commentId");

        $(".bg-modal-comments form").data("commentId", comment);
        $(".bg-modal-comments").toggleClass("modal-visible");

        return false;
    });

    $('.bg-modal-comments form').submit(function (event) {
        event.preventDefault();
        let btn = document.activeElement;
        btn.classList.toggle("load");
        btn.setAttribute("disabled", true);
        if (btn.querySelector(".fa-spin"))
            btn.querySelector(".fa-spin").classList.toggle("del");
        if (btn.querySelector(".text"))
            btn.querySelector(".text").classList.toggle("del");

        // console.log(this);
        // console.log(new FormData(this));
        let data = new FormData(this);
        data.append('comment', $(this).data("commentId"));
        // console.log($(this).data("commentId"));
        // console.log(data);
        // return false;

        console.log("ajax start");
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            // data: new FormData(this),
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {

                // console.log(result);
                $('.bg-modal-comments form .complain-user-daily').text(result);
                modalAlertNotification("Предупреждение успешно отправлено!","success");
                // json = jQuery.parseJSON(result);
                // // где используеться json.url? в каких экшенах
                // // view location
                // if (json.url) {
                //     window.location.href = '/' + json.url;
                // } else {
                //     alert(json.status + ' - ' + json.message);
                //     if (json.redirect)
                //         window.location.href = '/' + json.redirect;
                // }
            },
            error: function (data) {
            // console.log(data);
            json = jQuery.parseJSON(data.responseText);
                modalAlertNotification(json.message,json.status);
        }
        }).always(function(){
            btn.classList.toggle("load");
            btn.removeAttribute("disabled");
            if (btn.querySelector(".fa-spin"))
                btn.querySelector(".fa-spin").classList.toggle("del");
            if (btn.querySelector(".text"))
                btn.querySelector(".text").classList.toggle("del");
        });
    });
});
