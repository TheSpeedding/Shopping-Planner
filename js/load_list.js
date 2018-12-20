function processListLoad(content) {
    let list = document.getElementById("current");
    list.innerHTML = "";

    let messageBox = document.createElement("span");
    messageBox.id = "list_message";
    list.appendChild(messageBox);

    if ('success' in content) {
        let payload = content['payload'];

        // Heading.
        let heading = document.createElement("h2");
        heading.innerText = payload['name'];
        list.appendChild(heading);

        // Creation datetime.
        let createdText = document.createElement("div");
        let createdDate = Date.parse(payload['created']);
        createdText.id = "created";
        createdText.innerText = "Created: " + formatDate(createdDate);
        list.appendChild(createdText);
    }
    else if ('error' in content) {
        showMessage("list_message", content['error'], "error");
    }
}

async function loadListAsync(id, session) {
    let formData = new FormData();
    formData.append('controller', 'load_list');
    formData.append('session', session);
    formData.append('id', id);

    await fetch(url + "/php/controllers/controller.php", {
        method: 'POST',
        body: formData
    })
    .then(x => {
        if (!x.ok) {
            throw Error();
        }
        return x.json();
    })
    .then(x => processListLoad(x))
    .catch(function() {
        showMessage("list_message", "Unable to load a list.", "error");
    });
}

function addOnClickEventToList(item) {
    let link = item.firstElementChild;
    let listId = Number(link.getAttribute("data-id"));

    link.addEventListener('click', function(event) {
        setCookie("last_visited_list", listId);
        loadListAsync(listId, getCookie("session"));
    });
}

document.addEventListener('DOMContentLoaded', function() {   
    let lastVisitedListId = getCookie("last_visited_list");
    if (lastVisitedListId !== null) {
        loadListAsync(lastVisitedListId, getCookie("session"));
    }

    let list = document.getElementById("lists");
    let items = list.getElementsByTagName("li");

    for (let i = 0; i < items.length - 1; ++i) {
        addOnClickEventToList(items[i]);
    }
});