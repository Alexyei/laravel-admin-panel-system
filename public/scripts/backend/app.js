$('.btn-danger').click(function () {
    var res = confirm('Подтвердите действия');
    if(!res){
        return false;
    }
});
