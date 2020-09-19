const nav_cut = document.querySelector(".nav_cut");
nav_cut.addEventListener("click",function(){
    document.querySelector(".nav_box_2").classList.remove("slide");
})
const brgr = document.querySelector(".brgr");

brgr.addEventListener("click",()=>{
    document.querySelector(".nav_box_2").classList.add("slide");
})

const msg = document.querySelector(".msg");
if(msg)
{
    document.querySelector(".msg_cut").addEventListener("click",()=>{
        msg.classList.add("hide");
    })
}
const expand = document.querySelector(".expand");

expand.addEventListener("click",()=>{
    document.querySelector(".approval_p").classList.toggle("slide_p");
})