<?php

  include_once 'webhook_class.php';
  include_once 'send_telegram.php';

  $tg_bot_token = "7990623036:AAFk4cH7bd5GTV2yJyMQ5aOPGCA1v0_KHnQ";
  $tg_user_id = "1321800342";



  $Yandex_Alice_Cli = new Yandex_Alice_Cli_Class();
  $Tg = new Telegram_msg_Class();
  $Webhook = new Webhook_Class();

  $Webhook->Set_Type('yandex_alice');
  $Webhook->Get_Data();
  $Webhook->Parse_Data();
  $Webhook->Parse_Tokens();
  
  
  if ($Webhook->is_Out())
  {
	if ($Webhook->out_msg != "Алиса: ")
  {
	$msg = $Webhook->out_msg;
	$Tg->Send($tg_bot_token, $tg_user_id, $msg);
    $Yandex_Alice_Cli->Set_Sess_Id($Webhook->data_msg_sess_id);
    $Yandex_Alice_Cli->Send($Webhook->user_id, 'Сообщение отправлено',true);
  }
   else
  {
    $Yandex_Alice_Cli->Set_Sess_Id($Webhook->data_msg_sess_id);
    $Yandex_Alice_Cli->Send($Webhook->user_id, 'Продиктуйте сообщение для отправки',false);
  }
}
?>
