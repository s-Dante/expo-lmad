import { attendace_afi } from "./validations-afi.js";

const btn = document.getElementById("btn-registrar");
const form = document.getElementById("form");

btn.addEventListener("click", async(e)=>{
    e.preventDefault();

    if(await attendace_afi()) return;

    form.requestSubmit();
});