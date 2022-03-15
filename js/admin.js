/* 
* Updating status of order by clicking corresponding button.
*/
if (document.querySelector('#orders_container')){
	let orders = document.querySelector('#orders_container');
	orders.onclick = function(e) {
		if(document.querySelector('#'+e.target.id).classList.contains('status_btn')){
			let statusId = e.target.id.substring(1);
			if(confirm('Хотите изменить статус заказа '+statusId+'?')) updateStatusFunction(statusId);
		}
	}
}
async function updateStatusFunction(statusId){
	let formData = new FormData();
	formData.set("order_id",statusId);
	let response = await fetch('status_update.php', {
		method: 'POST',
		body: formData
	});
	if(response.ok){
		window.location.reload();
	}
}

/* 
* Deleting selected admin by clicking corresponding button.
*/
if (document.querySelector('#admins_container')){
	let admins = document.querySelector('#admins_container');
	admins.onclick = function(e) {
		if(document.querySelector('#'+e.target.id).classList.contains('delete_admin')){
			let adminId = e.target.id.substring(1);
			if(confirm('Хотите удалить админа #'+adminId+'?')) deleteAdmin(adminId);
		}
	}
}
async function deleteAdmin(adminId){
	let formData = new FormData();
	formData.set("id",adminId);
	let response = await fetch('delete_admin.php', {
		method: 'POST',
		body: formData
	});
	if(response.ok){
		window.location.reload();
	}
}

/* 
* If admin wants to create new admin and clicks the "ADD NEW ADMIN BUTTON",
* make form of creating new admin visible.
*/
function addNewAdminVisible(){
	let newAdmins = document.querySelector('#add_new_admin');
	newAdmins.style = "display: block;";
}