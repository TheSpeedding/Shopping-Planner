function showMessage(id, message, className) {
    let element = document.getElementById(id);
    if (element !== null) {
        element.classList.add(className);
        element.innerText = message;
        
        element.style.opacity = 1;
        setTimeout(function() { 
            element.style.opacity = 0;
         }, 5000);
    }
}
