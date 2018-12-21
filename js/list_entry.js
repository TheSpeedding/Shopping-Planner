class Entries {
    constructor(id) {
        this.entries = [];
        this.length = 0;
        this.listId = id;
    }

    add(x) {
        this.entries.push(x);
        this.length = this.entries.length;
        this.preserveInvariant();
    }

    remove(index) {
        this.entries.splice(index, 1);
        this.length = this.entries.length;
        this.preserveInvariant();
    }

    preserveInvariant() {
        // Invariant: The last entry in the list has no swap button, others do.
        for (let i = 0; i < this.entries.length - 1; ++i) {
            if (this.entries[i].row !== null) {
                this.entries[i].showSwapButtonElement();
            }
        }

        this.entries[this.entries.length - 1].hideSwapButtonElement();
    }
}

class Entry {
    constructor(id, name, amount, parentList) {
        this.id = id;
        this.name = name;
        this.amount = amount;
        this.parentList = parentList;
        this.index = this.parentList.length;
        this.row = this.createTableRow();

        this.parentList.add(this);
    }

    swapWithNext() {
        let fstPos = this.positionInList;
        let sndPos = this.positionInList + 1;
    }

    deleteEntry() {
        let formData = new FormData();
        formData.append('controller', 'remove_item');
        formData.append('id', this.id);
    
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
        .then(x =>  {
            this.row.parentElement.removeChild(this.row);
            this.parentList.remove(this.index);
        })
        .catch(function() {
            showMessage("list_message", "Unable to remove item.", "error", true);
        });
    }

    editAmount() {

    }

    getSwapButtonElement() {
        return this.row === null ? null : this.row.getElementsByTagName("td")[2].firstElementChild;
    }

    hideSwapButtonElement() {
        let b = this.getSwapButtonElement();
        if (b !== null) {
            b.style.display = "none"
        }
    }

    showSwapButtonElement() {
        let b = this.getSwapButtonElement();
        if (b !== null) {
            b.style.display = "initial"
        }
    }

    createTableRow() {
        let _this = this; // Otherwise a problem with passing 'this' object to an event handler.

        let currentRow = document.createElement("tr");
        currentRow.setAttribute("data-id", this.id);

        let itemEntry = document.createElement("td");
        itemEntry.innerHTML = this.name;
        currentRow.appendChild(itemEntry);

        let amountEntry = document.createElement("td");
        amountEntry.innerText = this.amount;
        currentRow.appendChild(amountEntry);

        let swapEntry = document.createElement("td");
        let swapLink = document.createElement("a");
        
        swapLink.classList.add("button_table");
        swapLink.classList.add("blue");
        swapLink.classList.add("swap");
        swapLink.innerText = "↑↓";
        swapLink.addEventListener('click', function(event) { ; });
        swapEntry.appendChild(swapLink);
        currentRow.appendChild(swapEntry);

        let actionsEntry = document.createElement("td");
        let editLink = document.createElement("a");
        let deleteLink = document.createElement("a");

        editLink.classList.add("yellow");
        editLink.innerText = "Edit";
        editLink.addEventListener('click', function(event) { ; });
        actionsEntry.appendChild(editLink);
        
        deleteLink.classList.add("red");
        deleteLink.innerText = "Delete";
        deleteLink.addEventListener('click', function(event) { _this.deleteEntry(); });
        actionsEntry.appendChild(deleteLink);

        currentRow.appendChild(actionsEntry);

        return currentRow;
    }
}

