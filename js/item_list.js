function appendToDatalist(names, datalist) {
    for (let i in names) {
        let option = document.createElement("option");
        option.setAttribute("value", names[i]);
        datalist.appendChild(option);
    }
}