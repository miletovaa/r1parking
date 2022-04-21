async function confirmTel(){
	let formData = new FormData();
	let userCode = document.getElementById('userCode').value;
	formData.set("user_code",userCode);
	let response = await fetch('phone_login.php', {
		method: 'POST',
		body: formData
	});
	if(response.ok){
		let result = await response.text();
		console.log(result);
		if(result == "true") window.location.href = 'today.php';
        else document.getElementById('loginerror').innerHTML = 'Ошибка. Осталось попыток: ' + (3-result);
	}
}