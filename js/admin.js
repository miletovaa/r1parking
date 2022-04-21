/* 
* Updating status of order by clicking corresponding button.
*/
function updateStatusBtn(obj) {
	if(document.querySelector('#'+obj.id).classList.contains('status_btn')){
		let statusId = obj.id.substring(1);
		if(confirm('Chcesz zaktualizować stan numeru linii '+statusId+'?')) updateStatusFunction(statusId);
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
			if(confirm('Chcesz usunąć administratora #'+adminId+'?')) deleteAdmin(adminId);
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

/* 
* SEARCH functions
*/
function searchIndexInput(){
	document.getElementById('searchOrderIndex').style = "display: block;";
	document.getElementById('searchDate').style = "display: none;";
	document.getElementById('searchStatusInput').style = "display: none;";
	document.getElementById('searchClientInput').style = "display: none;";
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
	document.getElementById('searchOrderIndex').style = "display: none;";
	document.getElementById('searchStatusInput').style = "display: none;";
	document.getElementById('searchRegInput').style = "display: none;";
	document.getElementById('searchClientInput').style = "display: none;";
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
function searchStatus(){
	document.getElementById('searchStatusInput').style = "display: block;";
	document.getElementById('searchDate').style = "display: none;";
	document.getElementById('searchOrderIndex').style = "display: none;";
	document.getElementById('searchRegInput').style = "display: none;";
	document.getElementById('searchClientInput').style = "display: none;";
}
if (document.querySelector('#searchStatusInput')){
	let searchStatus = document.querySelector('#searchStatusInput');
	searchStatus.addEventListener('input',function(e) {
		let row = '';
		for (let i=1; i< document.getElementsByClassName('order_row').length; i++){
			row = document.getElementsByClassName('order_row')[i];
			row.style = 'display: flex';
			console.log(row.children[1].innerHTML);
			if (row.children[1].innerHTML.toLowerCase().includes(searchStatus.value.toLowerCase())){
				if (searchStatus.value.toLowerCase() == 'potwierdzona' && row.children[1].innerHTML.toLowerCase().includes('nie')) row.style = 'display: none';
			}
			else row.style = 'display: none';
		}
	})
}
function searchRegInput(){
	document.getElementById('searchRegInput').style = "display: block;";
	document.getElementById('searchOrderIndex').style = "display: none;";
	document.getElementById('searchDate').style = "display: none;";
	document.getElementById('searchStatusInput').style = "display: none;";
	document.getElementById('searchClientInput').style = "display: none;";
}
if (document.querySelector('#searchRegInput')){
	let searchReg = document.querySelector('#searchRegInput');
	searchReg.addEventListener('input',function(e) {
		let row = '';
		for (let i=1; i< document.getElementsByClassName('order_row').length; i++){
			row = document.getElementsByClassName('order_row')[i];
			row.style = 'display: flex';
			console.log(row.children[4].innerHTML);
			if (row.children[4].innerHTML.toLowerCase().includes(searchReg.value.toLowerCase())) console.log('found');
			else row.style = 'display: none';
		}
	})
}
function searchClient(){
	document.getElementById('searchClientInput').style = "display: block;";
	document.getElementById('searchRegInput').style = "display: none;";
	document.getElementById('searchOrderIndex').style = "display: none;";
	document.getElementById('searchDate').style = "display: none;";
	document.getElementById('searchStatusInput').style = "display: none;";
}
if (document.querySelector('#searchClientInput')){
	let searchCli = document.querySelector('#searchClientInput');
	searchCli.addEventListener('input',function(e) {
		let row = '';
		for (let i=1; i< document.getElementsByClassName('order_row').length; i++){
			row = document.getElementsByClassName('order_row')[i];
			row.style = 'display: flex';
			console.log(row.children[5].innerHTML);
			if (row.children[5].innerHTML.toLowerCase().includes(searchCli.value.toLowerCase())) console.log('found');
			else row.style = 'display: none';
		}
	})
}

/*
* Generating more <inputs> for registrations in case we have them more than one car.
*/
function moreRej(event){
	event.preventDefault();
	newInp = document.querySelector('.rejestracja').cloneNode();
	newInp.value = '';
	document.getElementsByClassName('rejestracja')[0].parentElement.after(newInp);
}
function registrationsCollect(){
	let registration = '';
	for (let i=0; i< document.getElementsByClassName('rejestracja').length; i++){
		reg = document.getElementsByClassName('rejestracja')[i];
		registration = registration + reg.value + '<br>';
	}
	document.getElementById('registration').value = registration;
	document.getElementById('cars').value = document.getElementsByClassName('rejestracja').length;
}

/*
* Function counts price of Parking depending on selected time interval
* and price provided by Admin (in Admin Panel) to the Database.
*/
function countBill(){
	let dateEnter = Date.parse(document.querySelector('#dateEnterForm').value); // дата начала парковки
	let dateExit = Date.parse(document.querySelector('#dateExitForm').value); // дата конца парковки
	let forDays = (dateExit - dateEnter)/86400000;
	let cost = 0;

	switch (forDays) {
		case 1:
			cost = parseInt(document.querySelector('#costParkingDay1').innerHTML);
			break;
		case 2:
			cost = parseInt(document.querySelector('#costParkingDay2').innerHTML);
			break;
		case 3:
			cost = parseInt(document.querySelector('#costParkingDay3').innerHTML);
			break;
		case 4:
			cost = parseInt(document.querySelector('#costParkingDay4').innerHTML);
			break;
		case 5:
			cost = parseInt(document.querySelector('#costParkingDay5').innerHTML);
			break;
		case 6:
			cost = parseInt(document.querySelector('#costParkingDay6').innerHTML);
			break;
		case 7:
			cost = parseInt(document.querySelector('#costParkingDay7').innerHTML);
			break;
		case 8:
			cost = parseInt(document.querySelector('#costParkingDay8').innerHTML);
			break;
		case 9:
			cost = parseInt(document.querySelector('#costParkingDay9').innerHTML);
			break;
		case 10:
			cost = parseInt(document.querySelector('#costParkingDay10').innerHTML);
			break;
		case 11:
			cost = parseInt(document.querySelector('#costParkingDay11').innerHTML);
			break;
		case 12:
			cost = parseInt(document.querySelector('#costParkingDay12').innerHTML);
			break;
		case 13:
			cost = parseInt(document.querySelector('#costParkingDay13').innerHTML);
			break;
		case 14:
			cost = parseInt(document.querySelector('#costParkingDay14').innerHTML);
			break;
		default:
			cost = ((forDays - 14) * parseInt(document.querySelector('#costParkingDayAfter14').innerHTML)) + parseInt(document.querySelector('#costParkingDay14').innerHTML);
			break;
	  }

	document.querySelector('#forDays').value = forDays;
	if (cost < 0 ) cost = 0;
	console.log(cost);
	document.querySelector('#newResCostJS').innerHTML = cost;
	document.querySelector('#newResCost').value = cost;
	return true;
}
/*
* Show/hide delayed orders.
*/
function showDebt(){
	if (document.getElementById('showDebt').checked == true) window.location.href = '?debt=';
	else window.location.href = '?';
}