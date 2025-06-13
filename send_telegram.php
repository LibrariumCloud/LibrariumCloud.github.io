<?php
   class Telegram_msg_Class
{
  function Send($token, $user_id, $msg, $is_end = true)
  {
    if (strlen($user_id) < 1 || mb_strlen($msg) < 1) {return;}
	$test = file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $user_id . '&text=' . $msg);
  }
}
?>
