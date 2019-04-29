function switchClass(param){
    param.toString();
    let element = document.getElementById(param);
    if(element.classList.contains("d-none")){
        element.classList.remove("d-none");
    }else{
        element.classList.add("d-none");
    }
}