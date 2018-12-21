function appendToDatalist(items, datalist) {
    for (let i in items) {
        let option = document.createElement("option");
        option.setAttribute("value", decodeEntities(items[i]));
        datalist.appendChild(option);
    }
}

function fillDatalist(datalist) {    
    if (datalist !== null) {
        let formData = new FormData();
        formData.append('controller', 'fetch_items');

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
        .then(x => appendToDatalist(x["payload"], datalist))
        .catch(function() {
            console.log("Unable to fetch items.");
        });
    }
}