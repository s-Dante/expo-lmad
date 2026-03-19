import { register_afi } from "./validations-afi.js";

const btn = document.getElementById("btn-registrar");
const form = document.getElementById("form-register");

btn.addEventListener("click", async(e)=>{
    e.preventDefault();

    if(await register_afi()) return;

    form.requestSubmit();
});