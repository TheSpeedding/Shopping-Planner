function appendToDatalist(names, datalist) {
    for (let i in names) {
        let option = document.createElement("option");
        option.setAttribute("value", names[i]);
        datalist.appendChild(option);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let datalist = document.getElementById("items");
    
    if (datalist !== null) {
        let formData = new FormData();
        formData.append('controller', 'fetch_items');

        fetch("/php/controllers/controller.php", {
            method: 'POST',
            body: formData
        })
        .then(x => x.json())
        .then(x => appendToDatalist(x["payload"], datalist));
    }
});