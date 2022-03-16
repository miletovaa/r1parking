let lastUpdate = document.querySelector('#lastUpdate').innerHTML;
setInterval(
    async function(e){
        let formData = new FormData();
        formData.append("last_update", lastUpdate);
        let response = await fetch("update_orders_list.php", {
            method: 'POST',
            body: formData
        });
        if (response.ok) {
            let result = await response.text();
            if(result == "There are some updates!")location.reload();
        }
}, 1000);