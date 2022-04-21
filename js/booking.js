/* 
* Function makes block of VAT-info visible or invisible
* by clicking definite checkbox
*/
function vatFunction(){
	let vatBlock = document.querySelector('#vat');
	if (vatBlock.classList.contains('invisible')) vatBlock.classList.remove('invisible');
	else vatBlock.classList.add('invisible');
}

/* 
* Some functions that connect checkboxes with corresponding inscription
*/
function keyChecked(){
	if (document.querySelector('#keysForm').checked === true) document.querySelector('#keysForm').checked = false;
	else document.querySelector('#keysForm').checked = true;
	addToBill();
}
function vatChecked(){
	if (document.querySelector('#vatForm').checked === true) document.querySelector('#vatForm').checked = false;
	else document.querySelector('#vatForm').checked = true;
	vatFunction();
}
function rulesChecked(){
	if (document.querySelector('#rulesForm').checked === true) document.querySelector('#rulesForm').checked = false;
	else document.querySelector('#rulesForm').checked = true;
}
function freeHelpChecked(){
	if (document.querySelector('#freeHelp').checked === true) document.querySelector('#freeHelp').checked = false;
	else document.querySelector('#freeHelp').checked = true;
}
function sbscrbChecked(){
	if (document.querySelector('#subscribeForm').checked === true) document.querySelector('#subscribeForm').checked = false;
	else document.querySelector('#subscribeForm').checked = true;
}

/* 
* Function counts price of Parking depending on selected time interval
* and price provided by Admin (in Admin Panel) to the Database.
*/
async function countBill(){
	let dateEnter = Date.parse(document.querySelector('#dateEnterForm').value); // дата начала парковки
	let dateExit = Date.parse(document.querySelector('#dateExitForm').value); // дата конца парковки
	let forDays = (dateExit - dateEnter)/86400000;
	console.log(forDays);
	let cost = 0;

	if (!isNaN(forDays)){
		let formData = new FormData();
		formData.set("for_days",forDays);
		let response = await fetch('../book/req_cost.php', {
			method: 'POST',
			body: formData
		});
		let result = await response.text();
		cost = parseInt(result);
	}

	document.querySelector('#forDays').value = forDays;
	console.log(cost);
	document.querySelector('#billJS').innerHTML = cost;

	let more = 0;
	if (document.querySelector('#keysForm')){
		if (document.querySelector('#keysForm').checked === true) {
			more = more + parseInt(document.querySelector('#costKeys').innerHTML);
		}
	}

	let bill = cost + more;
	if (document.querySelector('#costAll'))	document.querySelector('#costAll').innerHTML = bill;
	if (document.querySelector('#bill')) document.querySelector('#bill').value = bill;
	return true;
}

/* 
* Function summarise price of Parking with price of selected additional services.
* Additional services prices provided by Admin (in Admin Panel) to the Database, as well.
*/
async function addToBill(){
	let keys = 'false';
	let more = 0;
	if (document.querySelector('#keysForm').checked === true) {
		keys = 'true';
		more = more + parseInt(document.querySelector('#costKeys').innerHTML);
	}
	let formData = new FormData();
	formData.set("cars",document.querySelector('#carsForm').value); // отправить кол-во машин
	formData.set("keys",keys); // отправить кол-во машин
	let response = await fetch('../book/update_cost.php', {
		method: 'POST',
		body: formData
	});
	let bill = await response.text();
	document.querySelector('#costAll').innerHTML = bill; // устанавливаем
	return true;
}

/* 
* Function changes language on page by selecting language in header.
*/
let langSelect = document.querySelector('#langSelect');
let index = 0;
function changeLang(){
	if(window.location.href.includes('lang')){
		index = window.location.href.indexOf('lang=') + 5;
		window.location.href = window.location.href.substr(0, index) + langSelect.value+ window.location.href.substr(index + langSelect.value.length);
	} else if(window.location.href.includes('?')){
		window.location.href = window.location.href + '&lang=' + langSelect.value;
	} else{
		window.location.href = window.location.href + '?lang=' + langSelect.value;
	}
}

/* 
* Function changes number of REGISTRATION <inputs> 
* depending on entered to the CARS <input> number.
*/
function carsInputs(){
let newInp = document.querySelector('.step3_reg').cloneNode();
	if (document.querySelector('#carsForm').value >= 1 && document.querySelector('#carsForm').value <=8){
		if (document.querySelector('#carsForm').value > document.getElementsByClassName('step3_reg').length){
			while(document.querySelector('#carsForm').value > document.getElementsByClassName('step3_reg').length){
				newInp = document.querySelector('.step3_reg').cloneNode();
				newInp.value = '';
				document.getElementsByClassName('step3_reg')[0].after(newInp);
			}
		}else if (document.querySelector('#carsForm').value < document.getElementsByClassName('step3_reg').length){
			while(document.querySelector('#carsForm').value < document.getElementsByClassName('step3_reg').length){
				document.getElementsByClassName('step3_reg')[0].remove();
			}
		}
		lastRegInput = document.querySelector('#carsForm').previousSibling;
		addToBill();
	}
}

/*
* Functions that make children and disabled persons fields available
*/
function inputChildrenFunc(){
	document.getElementById('childrenForm').style = "display: block;";
	document.getElementById('inputChildren').style = "display: none;";
	document.getElementById('inputChildren').parentElement.classList.remove('unselected');
}
function inputDisabledFunc(){
	document.getElementById('disabledForm').style = "display: block;";
	document.getElementById('inputDisabled').style = "display: none;";
	document.getElementById('inputDisabled').parentElement.classList.remove('unselected');
}

function registrationsCollect(){
	let registration = '';
	for (let i=0; i< document.getElementsByClassName('reg').length; i++){
		reg = document.getElementsByClassName('reg')[i];
		registration = registration + reg.value + '<br>';
	}
	document.getElementById('registrationForm').value = registration;
}

/*
* Function of autoinput client's data.
*/
async function autoinput(){
	let formData = new FormData();
	let tel = document.getElementById('telForm').value;
	formData.set("tel",tel);
	let token = window.location.href.substr(window.location.href.indexOf('token=') + 6);
	formData.set("token",token);
	console.log(token);

	let response = await fetch('../book/autoinput.php', {
		method: 'POST',
		body: formData
	});
	if(response.ok){
		let result = await response.text();
		if (result != 'no such user.' && result != 'token not found'){
			let inputs = result.split(';');
			console.log(inputs);

			// если это степ2, то автозаполняем поля
			if (document.getElementById('nameForm')){
				document.getElementById('nameForm').value = inputs[0];
				document.getElementById('mailForm').value = inputs[1];
			}
		}else console.log(result);
	}
}

if(document.getElementById('refresh').innerHTML == 'true') {
	if ((window.location.href.includes('R1') !== false) || (window.location.href.includes('R-1') !== false)) window.open('../book/step2.php');
	else if (window.location.href.includes('step2') !== false) {
		window.open('step3.php');
		window.close();
	}
	else if (window.location.href.includes('step3') !== false) {
		window.open('finish.php');
		window.close();
	}	
}