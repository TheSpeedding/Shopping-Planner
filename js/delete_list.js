function processListDeletion(content) {
    if ('error' in content) {
        throw new Error();
    }
    else if ('success' in content) {
        let id = content['payload']['id'];
        document.getElementById("list").innerHTML = "";

        let listItems = document.getElementById("lists").firstElementChild.getElementsByTagName("li");
        for (let i = 0; i < listItems.length; ++i) {
            let listId = listItems[i].firstElementChild.getAttribute("data-id");
            if (listId == id) {
                listItems[i].parentNode.removeChild(listItems[i]);
                break;
            }
        }

        deleteCookie("last_visited_list");
        showMessage("lists_message", "List deleted successfully.", "success", true);
    }
}

function deleteList(id) {
    let res = confirm("Do you really want to delete the list? This action cannot be undone!");
    if (res) {
        let formData = new FormData();
        formData.append('controller', 'delete_list');
        formData.append('id', id);

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
        .then(x => processListDeletion(x))
        .catch(function() {
            showMessage("list_message", "Unable to delete a list.", "error");
        });

    }
}