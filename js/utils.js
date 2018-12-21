function showMessage(id, message, className, fade = false) {
    let element = document.getElementById(id);
    if (element !== null) {
        element.classList.add(className);
        element.innerText = message;
        
        element.style.opacity = 1;
        if (fade) {         
            setTimeout(function() { 
                element.style.opacity = 0;
            }, 5000);
        }
    }
}

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    return parts.length == 2 ? parts.pop().split(";").shift() : null;
}

function setCookie(name, value) {
    document.cookie = name + "=" + value + ";";
}

function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  }

function formatDate(date) {
    let diff = new Date() - date; 

    if (diff < 1000) { 
        return 'right now';
    }

    let sec = Math.floor(diff / 1000); 

    if (sec < 60) {
        return sec + ' seconds ago';
    }

    let min = Math.floor(diff / 60000); 
    if (min < 60) {
        return min == 1 ? "a minute ago" : min + ' minutes ago';
    }

    let d = new Date(date);
    d = [
        '0' + d.getDate(),
        '0' + (d.getMonth() + 1),
        '' + d.getFullYear(),
        '0' + d.getHours(),
        '0' + d.getMinutes()
    ].map(component => component.slice(-2)); 

    return d.slice(0, 3).join('.') + ' ' + d.slice(3).join(':');
}