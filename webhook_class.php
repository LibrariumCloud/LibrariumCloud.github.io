<?php

include_once 'classes_alice.php';


class Yandex_Alice_Cli_Class
{
  public $data_msg_sess_id = "";

  function Set_Sess_Id($sess_id)
  {
    $this->data_msg_sess_id = $sess_id;
  }

  function Send($user_id, $out_text, $is_end, $out_tts = "")
  {

  ///// GENERATE BASE OF OUT //////
    $Data_Out = new Alice_Data_Out();
    $Data_Out->response = new Alice_Response();
    $Data_Out->session = new Alice_Session();
  ///// GENERATE BASE OF OUT End //////

  ///// OUT MSG GENERATE /////
    $Data_Out->session->session_id = $this->data_msg_sess_id;;
    $Data_Out->session->user_id = $user_id;

    $Data_Out->response->text = $out_text;
    $Data_Out->response->tts = $out_tts;

    if (mb_strlen($out_tts) < 1) {$Data_Out->response->tts = $out_text;}

    $Data_Out->response->end_session = $is_end;

    header('Content-Type: application/json');
    print(json_encode($Data_Out, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT));

    die();
  }

}

class Webhook_Class
{

  private $date = "";
  private $type = "";


  public $user_id = "";
  public $msg_user_name = "";
  public $msg_user_last_name = "";
  public $msg_user_nick_name = "";
  public $msg_chat_id = "";

  public $msg_text = "";
  public $tokens;

  public $out_msg = "";

  public $data_msg_sess_id = "";


  function Set_Type($type)
  {
    $this->type = $type;
  }



  function Get_Data()
  {
    $this->data = json_decode(trim(file_get_contents('php://input')), true);
  }


  function Parse_Data()
  {
    if ($this->type == 'yandex_alice')
    {
      if (isset($this->data['request']))
      {

        if (isset($this->data['meta']))
        {
          $this->data_meta = $this->data['meta'];
          if (isset($this->data_meta['client_id'])) {$client_id = $this->data_meta['client_id'];}
        }

        if (isset($this->data['request']))
        {
          $this->data_req = $this->data['request'];

          if (isset($this->data_req['original_utterance']))
          {
            $original_utterance = $this->data_req['original_utterance'];
          }

          if (isset($this->data_req['command'])) {$this->data_msg = $this->data_req['command'];}
          if (isset($this->data_req['nlu']))
          {
            $this->data_nlu = $this->data_req['nlu'];
            if (isset($this->data_nlu['tokens'])) {$this->tokens = $this->data_nlu['tokens'];}
      //      $this->data_token_count = count($this->data_tokens);
          }
        }
        if (isset($this->data['session']))
        {
          $this->data_session = $this->data['session'];
          if (isset($this->data_session['new'])) {$this->data_msg_new = $this->data_session['new'];}
          if (isset($this->data_session['message_id'])) {$this->data_msg_id = $this->data_session['message_id'];}
          if (isset($this->data_session['session_id'])) {$this->data_msg_sess_id = $this->data_session['session_id'];}
//          if (isset($this->data_session['skill_id'])) {$skill_id = $this->data_session['skill_id'];}
          if (isset($this->data_session['user_id'])) {$this->user_id = $this->data_session['user_id'];}
        }
      }
    }
    else
    {
/// TYPE of webhook NOT SET
      die();
    }

  }


  function Parse_Tokens()
  {
    // do something with tokens //
    $this->out_msg = "Алиса: ". implode($this->tokens, " ");
  }
 

  function is_Out()
  {
    return mb_strlen($this->out_msg) > 0;
  }

}



?>
