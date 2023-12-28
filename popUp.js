document.querySelector("#open-pop_up").addEventListener("click", function(){
    document.body.classList.add("active-popup");
});

document.querySelector(".pop_up .close-btn").addEventListener("click", function(){
    document.body.classList.remove("active-popup");
});