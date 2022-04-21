if (document.getElementById('tel_not_confirmed')) document.getElementById('tel_confirm_container').style = 'display: block;';
async function confirmTel(){
	let formData = new FormData();
	let userCode = document.getElementById('userCode').value;
	let tel = document.getElementById('telCode').value;
	let token = document.getElementById('token').value;
	formData.set("tel",tel);
	formData.set("user_code",userCode);
	formData.set("token",token);
	let response = await fetch('../phone_confirm/phone_confirm.php', {
		method: 'POST',
		body: formData
	});
	if(response.ok){
		let result = await response.text();
		console.log(result);
		if(result == "true") {
			document.getElementById('tel_confirm_container').style = 'display: none';
			if (window.location.href.includes('step2') !== false) {
				window.open('../book/step3.php');
				window.close();
			}
			if ((window.location.href.includes('R1') !== false) || (window.location.href.includes('R-1') !== false)) window.open('../book/step2.php');
		} else if(parseInt(result) < 3){
			document.getElementById('attempts').innerHTML = 3-parseInt(result);
			document.getElementById('tel_confirm_att').style = 'display: block;';
		} else if(parseInt(result) >= 3) {
			document.getElementById('tel_confirm_err').style = 'display: block;';
			document.getElementById('tel_confirm_att').style = 'display: none;';
			document.getElementById('sendUserCode').style = 'display: none;';
		}
	}
}