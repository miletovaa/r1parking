<footer>
    <div class="container">
        <div class="footer_inside column">
            <div class=""><?=$translate['developed_by'];?> B00KING.ONLINE © 2022</div>
            <div class="">
                <span class="developer_message" onclick="document.getElementById('message_container').style='display: block'; ">
                    <?=$translate['send_message_to_developer'];?>
                </span>
            </div>
        </div>
    </div>
</footer>
<?
/*
* Sending message from footer to Telegram.
*/
function devMessage($mes) {
        $response = ['chat_id' => '',
                    'text' => $mes];
        $ch = curl_init('https://api.telegram.org/bot/sendMessage');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $message_id = json_decode($result, true)['result']['message_id'];
        return $message_id;
}

if (isset($_POST['dev_message'])){
    $message = '';
    if (isset($_POST['name'])) $message .= $_POST['name'].' ';
    if (isset($_POST['phone'])) $message .= $_POST['phone'].' ';
    if (isset($_POST['mail'])) $message .= $_POST['mail'].' ';
    if (isset($_POST['message'])) $message .= "\n\n".$_POST['message'];
    devMessage($message);
}
?>

<div id="message_container" style="display: none;">
	<div id="message">
		<div>
			<span id="cross" onclick="document.getElementById('message_container').style = 'display: none;'">x</span>
			<form action="" class="message_form" method="post">
                <input type="text" name="name" placeholder="<?=$translate['full_name'];?>">
                <input type="text" name="phone" placeholder="<?=$translate['phone_number'];?>">
                <input type="text" name="mail" placeholder="<?=$translate['mail'];?>">
                <input type="text" name="message" placeholder="<?=$translate['message'];?>">
                <div class="message_btn">
                    <input type="submit" name="dev_message" value="<?=$translate['send_code'];?>">
                </div>
            </form>
		</div>
	</div>
</div>