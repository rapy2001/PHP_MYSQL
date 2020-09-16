const nav_cut = document.querySelector(".nav_cut");
nav_cut.addEventListener("click",function(){
    document.querySelector(".nav_box_2").classList.remove("slide");
})
const brgr = document.querySelector(".brgr");

brgr.addEventListener("click",()=>{
    document.querySelector(".nav_box_2").classList.add("slide");
})