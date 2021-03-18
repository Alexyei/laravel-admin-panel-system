let waiting = new Promise(function (resolve) {
    setTimeout(resolve, 1000);
});
window.addEventListener('load', function () {
    waiting.then(function (){
        document.querySelector(".overlay").style.display = 'none';
        document.body.classList.remove("no-scroll")
    })

});
