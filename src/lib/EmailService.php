<?php

namespace src\lib;

use Symfony\Component\HttpFoundation\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use src\db\orm\model\User;
use src\lib\Auth;

/*
 * Class abstrction of PHPMailer
 *
 */

class EmailService
{
    private $server;
    private $port;
    private $user;
    private $password;
    private $userId;
    private $email;
    private $name;
    private $body;
    private $altBody;
    private $action;
    private $msg;
    private $msg_alt;

    public function __construct($action = null)
    {
        $params = json_decode(file_get_contents(__DIR__.'/../../conf/email.json'), true);

        $this->server = $params['server'];
        $this->port = $params['port'];
        $this->user = $params['user'];
        $this->password = $params['password'];
        $this->action = $action;
    }


    /**
     * Sends the email.
     *
     * @return Boolean/Exception of the operation.
     */

    public function send()
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $this->server;
            $mail->Port = $this->port;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = $this->user;
            $mail->Password = $this->password;
            $mail->setFrom($this->user, 'Virtuagym');
            $mail->addAddress($this->email, $this->name);
// developing use
$mail->addAddress('querof@gmail.com', $this->name);
// developing use 
            $mail->Subject = 'Virtuagym Info';
            $mail->isHTML(true);
            $mail->Body = $this->body;
            $mail->AltBody = $this->altBody;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }


    /**
     * Config the PHPMailer object.
     *
     * @param String/Integer $token. Token of AUTH system/userId.
     *
     * @return Json of the query result; according
     *         with resulset of the database.
     */

    public function configEmail($token)
    {
        $u = $this->getUser($token);

        if ($this->action=='register') {
            $this->userId = $u[0]['id'];
            $this->name = $u[0]['name'];
            $this->email = $u[0]['email'];
        } else {
            $this->userId = $u[0]['user_id'];
            $this->name = $u[0]['user_name'];
            $this->email = $u[0]['user_email'];
        }

        $this->setBody();
    }


    /**
     * Set the email body.
     */

    private function setBody()
    {
        $msg = $this->getMsg();

        $this->body =	'<html>
          <head></head>
          <body>
            <h3>Virtuagym</h3>
            <hr/>
            <p>'.$this->msg.'</p>
            <hr/>
          </body>
        </html>';

        $this->altBody = $this->msg_alt;
    }


    /**
     * Returns the user object.
     *
     * @param String/Integer $token. Token of AUTH system/userId.
     *
     * @return Obj of the query result; according  with resulset of the database.
     */

    private function getUser($token)
    {
        $u = new User();

        return $this->action=='register'?$u->findByPk($token):$u->findBy(array("user"=>array("id"=>array(),"name"=>array(),"email"=>array("value"=>$this->decodeEmail($token)))));
    }

    /**
     * Decode the user email from token.
     *
     * @param String $token. Token of AUTH system.
     *
     * @return String email of the user.
     */

    private function decodeEmail($token)
    {
        $data = Auth::GetData($token);
        return $data->email->value;
    }


    /**
     * Sets Msg of the email body.     *
     */

    private function getMsg()
    {
        switch ($this->action) {
        case 'register':
            $link =(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]confirm/" . $this->userId;

            $this->msg = 'You has been registered!, please confirm you registration <a href="'.$link. '">here!</a>';
            $this->msg_alt = ' user this link to confirm your account: '.$link;
          break;
        case 'plan_create':
            $this->msg = 'Your plan was created!';
            $this->msg_alt = $this->msg;
          break;
        case 'plan_update':
          $this->msg = 'Your plan was upated!';
          $this->msg_alt = $this->msg;
          break;
        case 'plan_delete':
          $this->msg = 'Your plan was deleted!';
          $this->msg_alt = $this->msg;
          break;
      }
    }
}
