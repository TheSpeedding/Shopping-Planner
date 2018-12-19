function showErrorMessage(id, message) {
    showMessage(id, message, "error");
}

function showSuccessMessage(id, message) {
    showMessage(id, message, "success");
}

function showMessage(id, message, cl) {
    let element = document.getElementById(id);
    element.classList.add(cl);
    element.innerText = message;
}