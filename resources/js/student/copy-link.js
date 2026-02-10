/*
    para copiar los links del proyecto (youtube, github, drive...)
*/

const btnsCopy = document.querySelectorAll('.btn-icon');

btnsCopy.forEach(btns =>{
    btns.addEventListener('click', (e) =>{
        e.preventDefault();

        let fragment = btns.getAttribute('data-target');
        let p = document.getElementById(fragment);
        let link = p.innerText;

        navigator.clipboard.writeText(link);

    });
});