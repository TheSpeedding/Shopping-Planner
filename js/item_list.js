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
        fetch("/php/controllers/fetch_items.php")
        .then(x => x.json())
        .then(x => appendToDatalist(x, datalist));
    }
});