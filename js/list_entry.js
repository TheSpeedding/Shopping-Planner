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

    remove(item) {
        item.row.parentElement.removeChild(item.row);
        this.entries.splice(this.entries.indexOf(item), 1);
        this.length = this.entries.length;
        this.preserveInvariant();
    }

    swapWithNext(fst) {
        let fstIndex = this.entries.indexOf(fst);
        let sndIndex = fstIndex + 1;
        let snd = this.entries[sndIndex];

        // Swap rows in table.
        let table = fst.row.parentElement;
        table.removeChild(snd.row);
        table.insertBefore(snd.row, fst.row);

        // Swap items in wrapper list.
        let tmp = this.entries[fstIndex];
        this.entries[fstIndex] = this.entries[sndIndex];
        this.entries[sndIndex] = tmp;

        this.preserveInvariant();
    }

    preserveInvariant() {
        // Invariant: The last entry in the list has no swap button, others do.
        for (let i = 0; i < this.entries.length - 1; ++i) {
            this.entries[i].showSwapButtonElement();
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
        this.row = this.createTableRow();

        this.parentList.add(this);
    }

    swapWithNext() {
        let formData = new FormData();
        formData.append('controller', 'swap_items');
        formData.append('id1', this.id);
        formData.append('id2', this.row.nextElementSibling.getAttribute("data-id"));

        sendControllerRequestAsync(formData)
        .then(x =>  {
            this.parentList.swapWithNext(this);
        })
        .catch(function() {
            showMessage("list_message", "Unable to swap items.", "error", true);
        });
    }

    deleteEntry() {
        let formData = new FormData();
        formData.append('controller', 'remove_item');
        formData.append('id', this.id);
    
        sendControllerRequestAsync(formData)
        .then(x =>  {
            this.parentList.remove(this);
        })
        .catch(function() {
            showMessage("list_message", "Unable to remove item.", "error", true);
        });
    }

    editAmount(n) {
        if (!Number.isInteger(n) || n < 1) {
            showMessage("list_message", "Unable to edit item, invalid argument.", "error", true);
        }

        else {
            let formData = new FormData();
            formData.append('controller', 'change_amount');
            formData.append('id', this.id);
            formData.append('amount', n);

            sendControllerRequestAsync(formData)
            .then(x => {
                if ('error' in x) {
                    throw new Error();
                }
                else if ('success' in x) {
                    this.setNewAmount(n);
                }
            })
            .catch(function() {
                showMessage("list_message", "Unable to edit item.", "error", true);
            });
        }
    }

    setNewAmount(n) {
        this.amount = n;
        this.row.getElementsByTagName("td")[1].getElementsByTagName("span")[0].innerText = this.amount;
        this.row.getElementsByTagName("td")[1].getElementsByTagName("input")[0].value = this.amount;
    }

    setAllButtonsDisplayStyle(visible) {
        let list = document.getElementById("list").getElementsByTagName("table")[0];
        let buttons = list.getElementsByTagName("a");

        for (let i = 0; i < buttons.length; ++i) {
            if (!buttons[i].classList.contains("edit_item")) {
                buttons[i].style.display = visible ? "inline" : "none";
            }
        }

        let editElements = this.row.getElementsByClassName("edit_item");

        for (let i = 0; i < editElements.length; ++i) {
            editElements[i].style.display = visible ? "none" : "inline";
        }

        this.row.getElementsByTagName("td")[1].getElementsByTagName("span")[0].style.display = visible ? "inline" : "none";

        if (visible) {
            this.parentList.preserveInvariant();
        }
    }

    hideAllButtonsAndEditItem() {
        this.row.getElementsByTagName("td")[1].getElementsByTagName("input")[0].setAttribute("value", this.amount);
        this.setAllButtonsDisplayStyle(false)
    }
    
    discardChangesAndShowAllButtons() {
        this.row.getElementsByTagName("td")[1].getElementsByTagName("input")[0].value = this.amount;
        this.setAllButtonsDisplayStyle(true);
    }

    submitItemEditAndShowAllButtons() {
        let newAmount = Number(this.row.getElementsByTagName("td")[1].getElementsByTagName("input")[0].value);
        this.editAmount(newAmount);
        this.setAllButtonsDisplayStyle(true);
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

        // Item name.
        let itemEntry = document.createElement("td");
        itemEntry.innerHTML = this.name;
        currentRow.appendChild(itemEntry);

        // Amount.
        let amountEntry = document.createElement("td");

        let amountSpan = document.createElement("span");
        amountSpan.innerText = this.amount;
        amountEntry.appendChild(amountSpan);

        // Edit amount input.
        let editAmount = document.createElement("input");
        editAmount.classList.add("edit_item");
        editAmount.setAttribute("type", "number");
        editAmount.setAttribute("min", "1");
        editAmount.setAttribute("value", this.amount);
        editAmount.required = true;
        amountEntry.appendChild(editAmount);

        currentRow.appendChild(amountEntry);

        let swapEntry = document.createElement("td");
        let swapLink = document.createElement("a");
        
        // Swap button.
        swapLink.classList.add("button_table");
        swapLink.classList.add("blue");
        swapLink.classList.add("swap");
        swapLink.innerText = "↑↓";
        swapLink.addEventListener('click', function(event) { _this.swapWithNext(); });
        swapEntry.appendChild(swapLink);

        currentRow.appendChild(swapEntry);

        let actionsEntry = document.createElement("td");
        let editLink = document.createElement("a");
        let deleteLink = document.createElement("a");
        let saveLink = document.createElement("a");
        let cancelLink = document.createElement("a");

        // Edit button.
        editLink.classList.add("yellow");
        editLink.innerText = "Edit";
        editLink.addEventListener('click', function(event) { _this.hideAllButtonsAndEditItem(); });
        actionsEntry.appendChild(editLink);
        
        // Delete button.
        deleteLink.classList.add("red");
        deleteLink.innerText = "Delete";
        deleteLink.addEventListener('click', function(event) { _this.deleteEntry(); });
        actionsEntry.appendChild(deleteLink);

        // Save edit button.
        saveLink.classList.add("green");
        saveLink.classList.add("edit_item");
        saveLink.innerText = "Save";
        saveLink.addEventListener('click', function(event) { _this.submitItemEditAndShowAllButtons(); });
        actionsEntry.appendChild(saveLink);

        // Cancel button.
        cancelLink.classList.add("red");
        cancelLink.classList.add("edit_item");
        cancelLink.innerText = "Cancel";
        cancelLink.addEventListener('click', function(event) { _this.discardChangesAndShowAllButtons(); });
        actionsEntry.appendChild(cancelLink);

        currentRow.appendChild(actionsEntry);

        return currentRow;
    }
}

