const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

const reset_btn = document.querySelector(".social-text");
const registration_form = document.querySelector(".registration");
const reset_form = document.querySelector(".reset");
// console.log(registration_form);
// console.log(reset_btn);
// console.log(reset_form);

if (sign_up_btn)
    sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign-up-mode");
    });
if (reset_btn)
    reset_btn.addEventListener("click", (event) => {
        // не добавлять знак hash в url
        event.preventDefault();
      if (registration_form)
        registration_form.classList.add("hidden");
        reset_form.classList.remove("hidden");
        container.classList.add("sign-up-mode");
    });

if (sign_in_btn)
    sign_in_btn.addEventListener("click", () => {
      if (registration_form)
        registration_form.classList.remove("hidden");
        reset_form.classList.add("hidden");
        container.classList.remove("sign-up-mode");
    });


