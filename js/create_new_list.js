function processListAddition(content) {
    if ('success' in content) {
        showMessage("lists_message", content['success'], "success");
        // Add a new node to DOM.
        let list = document.getElementById("lists").getElementsByTagName("ul")[0];
        let newLi = document.createElement("li");
        let newA = document.createElement("a");
        newA.setAttribute("href", "#");
        newA.innerText = content['payload']['name'];
        newLi.appendChild(newA);
        list.appendChild(newLi);
    }
    else if ('error' in content) {
        showMessage("lists_message", content['error'], "error");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let button = document.getElementById("create_new_list");

    button.addEventListener('click', function (event) {
        let name = prompt("Enter name for a new list:", "");

        if (name !== null) {
            let urlCurrent = new URL(window.location.href);
            let session = urlCurrent.searchParams.get("session");

            let formData = new FormData();
            formData.append('controller', 'create_new_list');
            formData.append('session', session);
            formData.append('name', name);

            fetch(url + "/php/controllers/controller.php", {
                method: 'POST',
                body: formData
            })
            .then(x => {
                if (!x.ok) {
                    throw Error();
                }
                return x.json();
            })
            .then(x => processListAddition(x))
            .catch(function() {
                console.log("Unable to create a new list.");
            });
        }
    });
});