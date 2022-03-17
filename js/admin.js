/* 
* Updating status of order by clicking corresponding button.
*/
function updateStatusBtn() {
	if(document.querySelector('#'+e.target.id).classList.contains('status_btn')){
		let statusId = e.target.id.substring(1);
		if(confirm('Хотите изменить статус заказа '+statusId+'?')) updateStatusFunction(statusId);
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


function searchIndexInput(){
	document.getElementById('searchOrderIndex').style = "display: block;";
}
if (document.querySelector('#searchOrderIndex')){
	let searchOrderIndex = document.querySelector('#searchOrderIndex');
	searchOrderIndex.addEventListener('input',function(e) {
		let row = '';
		for (let i=1; i< document.getElementsByClassName('order_row').length; i++){
			row = document.getElementsByClassName('order_row')[i];
			row.style = 'display: flex';
			console.log(row.children[0].innerHTML);
			if (row.children[0].innerHTML.toLowerCase().includes(searchOrderIndex.value.toLowerCase())) console.log('found');
			else row.style = 'display: none';
		}
	})
}

function searchDateInput(){
	document.getElementById('searchDate').style = "display: block;";
}
if (document.querySelector('#searchDate')){
	let searchDate = document.querySelector('#searchDate');
	searchDate.addEventListener('input',function(e) {
		let row = '';
		for (let i=1; i< document.getElementsByClassName('order_row').length; i++){
			row = document.getElementsByClassName('order_row')[i];
			row.style = 'display: flex';
			console.log(row.children[3].innerHTML);
			if (row.children[3].innerHTML.toLowerCase().includes(searchDate.value.toLowerCase())) console.log('found');
			else row.style = 'display: none';
		}
	})
}