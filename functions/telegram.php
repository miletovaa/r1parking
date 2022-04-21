<?
// * TELEGRAM BOT API
class TelegramBot {
    public static function sendMessageTo($mes) {
        $response = ['chat_id' => '123',
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
    public static function updateMessage($mes, $mes_id) {
        $response = ['message_id' => $mes_id,
                    'chat_id' => '123',
                    'text' => $mes];
        $ch = curl_init('https://api.telegram.org/bot/editMessageText');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
?>