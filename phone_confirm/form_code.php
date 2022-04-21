<? if(!$_SESSION['tel_confirmed'] && $_SESSION['code_errors'] < 3){ 
    include_once 'API/sms';
    /*
    ! Here we already use API of sending SMS
    */
?>
<div id="tel_not_confirmed"></div>
<? } ?>
<div id="tel_confirm_container" style="display: none;">
	<div id="tel_confirm">
		<div id="tel_confirm_inner">
			<span id="cross" onclick="document.getElementById('tel_confirm_container').style = 'display: none;'">x</span>
			<?=$translate['input_your_phone_number'];?> <br><? echo substr($tel,0,3).' '.substr($tel, 3, 3).'-'.substr($tel, 6, 3).'-'.substr($tel, 9, 3);?><br>
			<?=$translate['you_will_get_sms'];?>
			<div id="tel_confirm_att" style="display: none;"><?=$translate['incorrect_code'];?><span id="attempts"></span><a href='?token=<?=$_GET['token']?>&send_code=<?=$tel;?>'><?=$translate['send_again'];?></a></div>
			<div id="tel_confirm_err" style="display: none;"><?=$translate['three_times_incorrect'];?> <a href="tel:+48797650599">+48 797-650-599</a></div>
			<div id="code_row">
				<input type="text" name="user_code" id="userCode">
				<input type="hidden" id="telCode" value="<?=$tel;?>">
				<input type="hidden" id="token" value="<?=$_GET['token'];?>">
				<input type="submit" id="sendUserCode" value="<?=$translate['send_code'];?>" onclick="confirmTel()">
			</div>
			<div class="note"><?=$translate['you_agree'];?></div>
		</div>
	</div>
</div>