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
function countBill(){
	let dateEnter = Date.parse(document.querySelector('#dateEnterForm').value); // дата начала парковки
	let dateExit = Date.parse(document.querySelector('#dateExitForm').value); // дата конца парковки
	let forDays = (dateExit - dateEnter)/86400000;
	let cost = 0;

	if (forDays == 1) cost = parseInt(document.querySelector('#costParkingDay1').innerHTML);
	else if (forDays == 2) cost = parseInt(document.querySelector('#costParkingDay2').innerHTML);
	else if (forDays == 3) cost = parseInt(document.querySelector('#costParkingDay3').innerHTML);
	else if (forDays == 4) cost = parseInt(document.querySelector('#costParkingDay4').innerHTML);
	else if (forDays == 5) cost = parseInt(document.querySelector('#costParkingDay5').innerHTML);
	else if (forDays == 6) cost = parseInt(document.querySelector('#costParkingDay6').innerHTML);
	else if (forDays == 7) cost = parseInt(document.querySelector('#costParkingDay7').innerHTML);
	else if (forDays == 8) cost = parseInt(document.querySelector('#costParkingDay8').innerHTML);
	else if (forDays == 9) cost = parseInt(document.querySelector('#costParkingDay9').innerHTML);
	else if (forDays == 10) cost = parseInt(document.querySelector('#costParkingDay10').innerHTML);
	else if (forDays == 11) cost = parseInt(document.querySelector('#costParkingDay11').innerHTML);
	else if (forDays == 12) cost = parseInt(document.querySelector('#costParkingDay12').innerHTML);
	else if (forDays == 13) cost = parseInt(document.querySelector('#costParkingDay13').innerHTML);
	else if (forDays == 14) cost = parseInt(document.querySelector('#costParkingDay14').innerHTML);
	else if (forDays > 14){
		cost = ((forDays - 14) * parseInt(document.querySelector('#costParkingDayAfter14').innerHTML)) + parseInt(document.querySelector('#costParkingDay14').innerHTML);
	}

	document.querySelector('#forDays').value = forDays;
	if (cost < 0 ) cost = 0;
	console.log(cost);
	document.querySelector('#billJS').innerHTML = cost;
	document.querySelector('#costParking').value = cost;

	let costParking = parseInt(document.querySelector('#costParking').value);
	let more = 0;
	if (document.querySelector('#keysForm')){
		if (document.querySelector('#keysForm').checked === true) {
			more = more + parseInt(document.querySelector('#costKeys').innerHTML);
		}
	}

	let bill = costParking + more;
	document.querySelector('#costAll').innerHTML = bill;
	document.querySelector('#bill').value = bill;
	return true;
}

/* 
* Function summarise price of Parking with price of selected additional services.
* Additional services prices provided by Admin (in Admin Panel) to the Database, as well.
*/
function addToBill(){
	let costParking = parseInt(document.querySelector('#costParking').innerHTML);
	if (document.querySelector('#carsForm').value >= 1){
		costParking = costParking * document.querySelector('#carsForm').value;
	}
	document.querySelector('#costAll').innerHTML = costParking;

	let more = 0;
	if (document.querySelector('#keysForm').checked === true) {
		more = more + parseInt(document.querySelector('#costKeys').innerHTML);
	}

	let bill = costParking + more;
	document.querySelector('#costAll').innerHTML = bill; // устанавливаем
	document.querySelector('#bill').value = bill;
	return true;
}

/* 
* Function changes language on page by selecting language in header.
*/
let langSelect = document.querySelector('#langSelect');
let index = 0;
function changeLang(){
	// window.location.reload();
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
let lastRegInput = document.querySelector('#carsForm').previousSibling;
let newInp = document.querySelector('.step3_reg').cloneNode();
function carsInputs(){
	if (document.querySelector('#carsForm').value >= 1 && document.querySelector('#carsForm').value <=8){
		if (document.querySelector('#carsForm').value > document.getElementsByClassName('step3_reg').length){
			while(document.querySelector('#carsForm').value > document.getElementsByClassName('step3_reg').length){
				// document.getElementsByClassName('step3_reg')[-1].remove();
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
		registration = registration + reg.value + '; ';
	}
	document.getElementById('registrationForm').value = registration;
}