function showMessage(id, message, className) {
    let element = document.getElementById(id);
    if (element !== null) {
        element.classList.add(className);
        element.innerText = message;
    }
}