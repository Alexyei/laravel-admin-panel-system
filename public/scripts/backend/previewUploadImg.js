if (document.querySelector("#mainImg"))
    document.querySelector("#mainImg").
 //   forEach((el)=>
 //   {
       // el.
    addEventListener('change', function (event) {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                let preview = document.querySelector(".img-uploaded");
                preview.src = src;
                preview.style.display = "block";
            }
        });
  //  });
