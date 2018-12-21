var entries = [];

class Entry {
    constructor(id, name, amount, positionInList) {
        this.id = id;
        this.name = name;
        this.amount = amount;
        this.positionInList = positionInList;

        entries.push(this);
    }

    swapWithNext() {
        let fstPos = this.positionInList;
        let sndPos = this.positionInList + 1;
    }

    deleteEntry() {


        entries.splice(this.positionInList, 1);
    }

    editAmount() {

    }

    createTableRow(excludeSwapButton = false) {
        let currentRow = document.createElement("tr");
        currentRow.setAttribute("data-id", this.id);

        let itemEntry = document.createElement("td");
        itemEntry.innerHTML = this.name;
        currentRow.appendChild(itemEntry);

        let amountEntry = document.createElement("td");
        amountEntry.innerText = this.amount;
        currentRow.appendChild(amountEntry);

        let swapEntry = document.createElement("td");
        if (excludeSwapButton) {
            let swapLink = document.createElement("a");
            
            swapLink.classList.add("button_table");
            swapLink.classList.add("blue");
            swapLink.classList.add("swap");
            swapLink.innerText = "↑↓";
            swapLink.addEventListener('click', function(event) { ; });
            swapEntry.appendChild(swapLink);
        }
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
        deleteLink.addEventListener('click', function(event) { ; });
        actionsEntry.appendChild(deleteLink);

        currentRow.appendChild(actionsEntry);

        return currentRow;
    }
}

