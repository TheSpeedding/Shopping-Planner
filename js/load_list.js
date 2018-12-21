function processListLoad(content) {
    let list = document.getElementById("list");
    list.innerHTML = "";

    if ('success' in content) {
        let payload = content['payload'];

        // This can be a local variable, since all the entries contain reference to this list. So it is inaccessible out of the scope.
        let entries = new Entries(Number(payload['id']));

        // Heading.
        let heading = document.createElement("h2");
        heading.innerHTML = payload['name'];
        list.appendChild(heading);

        // Creation datetime.
        let createdText = document.createElement("div");
        let createdDate = Date.parse(payload['created']);
        createdText.id = "created";
        createdText.innerText = "Created: " + formatDate(createdDate);
        list.appendChild(createdText);

        let form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "#");      

        // Table itself.
        let table = document.createElement("table");

        let headingRow = document.createElement("tr");
        let headers = [ document.createElement("th"), 
                        document.createElement("th"), 
                        document.createElement("th"), 
                        document.createElement("th") ];   

        headers[0].innerText = "Item";
        headers[1].innerText = "Amount";
        headers.forEach(x => headingRow.appendChild(x));
        table.appendChild(headingRow);

        // Existing items.
        for (let i = 0; i < payload['items'].length; ++i) {
            let item = payload['items'][i];

            let entry = new Entry(item['id'], item['item'], item['amount'], entries);

            table.appendChild(entry.row);
        }

        // Form to create a new entry.  
        let lastRow = document.createElement("tr");

        let nameEntry = document.createElement("td");

        // Item name input.
        let inputName = document.createElement("input");
        inputName.setAttribute("type", "text");
        inputName.setAttribute("list", "items");
        inputName.setAttribute("name", "item");
        inputName.required = true;
        nameEntry.appendChild(inputName);

        let datalistItems = document.createElement("datalist");
        datalistItems.id = "items";
        fillDatalist(datalistItems);
        nameEntry.appendChild(datalistItems);

        lastRow.appendChild(nameEntry);
        
        let amountEntry = document.createElement("td");

        // Amount input.
        let inputAmount = document.createElement("input");
        inputAmount.setAttribute("type", "number");
        inputAmount.setAttribute("min", "1");
        inputAmount.setAttribute("name", "amount");
        inputAmount.required = true;
        amountEntry.appendChild(inputAmount);

        lastRow.appendChild(amountEntry);

        let buttonsEntry = document.createElement("td");
        buttonsEntry.setAttribute("colspan", "2");
        buttonsEntry.style.padding = "0 12px";
        
        // Hidden input for controller chosing.
        let controller = document.createElement("input");
        controller.setAttribute("type", "hidden");
        controller.setAttribute("name", "controller");
        controller.setAttribute("value", "add_item");
        controller.classList.add("green");
        buttonsEntry.appendChild(controller);

        // Add button.
        let submitButton = document.createElement("input");
        submitButton.setAttribute("type", "submit");
        submitButton.setAttribute("value", "Add");
        submitButton.classList.add("green");
        buttonsEntry.appendChild(submitButton);
        
        // Clear button.
        let clearButton = document.createElement("input");
        clearButton.setAttribute("type", "button");
        clearButton.setAttribute("value", "Clear");
        clearButton.classList.add("yellow");
        clearButton.addEventListener('click', function(event) {
            let inputs = lastRow.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; ++i) {
                if (inputs[i].type != "button" && inputs[i].type != "submit") {
                    inputs[i].value = "";
                }
            }
        });
        buttonsEntry.appendChild(clearButton);

        lastRow.appendChild(buttonsEntry);
        table.appendChild(lastRow);
        form.appendChild(table);

        list.appendChild(form);

        // Button to delete a list.
        let deleteWrapper = document.createElement("div");
        deleteWrapper.id = "delete_list";
        let deleteLink = document.createElement("a");
        deleteLink.innerText = "Delete list";
        deleteLink.addEventListener('click', function(event) { deleteList(payload['id']); });

        deleteWrapper.appendChild(deleteLink);
        list.appendChild(deleteWrapper);
    }
    else if ('error' in content) {
        deleteCookie("last_visited_list");
        showMessage("list_message", content['error'], "error");
    }
}

function loadList(id) {
    let formData = new FormData();
    formData.append('controller', 'load_list');
    formData.append('id', id);

    fetch(url + "/php/controllers/controller.php", {
        method: 'POST',
        body: formData
    })
    .then(x => {
        if (!x.ok) {
            throw new Error();
        }
        return x.json();
    })
    .then(x => processListLoad(x))
    .catch(function() {
        deleteCookie("last_visited_list");
        showMessage("list_message", "Unable to load a list.", "error");
    });
}

function addOnClickEventToList(item) {
    let link = item.firstElementChild;
    let listId = Number(link.getAttribute("data-id"));

    link.addEventListener('click', function(event) {
        setCookie("last_visited_list", listId);
        loadList(listId);
    });
}

document.addEventListener('DOMContentLoaded', function() {   
    let lastVisitedListId = getCookie("last_visited_list");
    if (lastVisitedListId !== null) {
        loadList(lastVisitedListId);
    }

    let list = document.getElementById("lists");
    let items = list.getElementsByTagName("li");

    for (let i = 0; i < items.length - 1; ++i) {
        addOnClickEventToList(items[i]);
    }
});