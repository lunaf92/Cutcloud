$('body').on('keydown', 'input, select, textarea', function(e) {
  var self = $(this)
    , form = self.parents('form:eq(0)')
    , focusable
    , next
    ;
  if (e.keyCode == 13) {
      focusable = form.find('input,a,select,button,textarea').filter(':visible');
      next = focusable.eq(focusable.index(this)+1);
      if (next.length) {
          next.focus();
      } else {
          form.submit();
      }
      return false;
  }
});

function switchClass(param){
    param.toString();
    let element = document.getElementById(param);
    if(element.classList.contains("d-none")){
        element.classList.remove("d-none");
    }else{
        element.classList.add("d-none");
    }
}

function changeColor(id){	
	id.toString();
  let element = document.getElementById('color'+id);
	let bg = document.getElementById(id).style.backgroundColor;
  console.log(element.value);
  if(bg=="rgb(255, 255, 255)"){
    //blue
  	document.getElementById(id).style.background = "rgb(0, 112, 192)";
    return element.value = "rgb(0, 112, 192)";
  }else if(bg == "rgb(0, 112, 192)"){
    // bright yellow
  	document.getElementById(id).style.background = "rgb(255, 254, 4)";
      return element.value = "rgb(255, 254, 4)";
  }else if(bg == "rgb(255, 254, 4)"){
    //green
      document.getElementById(id).style.background = "rgb(112, 173, 70)";
    return element.value = "rgb(112, 173, 70)";
  }else if(bg == "rgb(112, 173, 70)"){
    // dark yellow
      document.getElementById(id).style.background = "rgb(255, 192, 0)";
    return element.value = "rgb(255, 192, 0)";
  }else{
    // white
  	document.getElementById(id).style.background = "rgb(255, 255, 255)";
    return element.value = "rgb(255, 255, 255)";
  }
}