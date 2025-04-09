<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  
  //Load Composer's autoloader
  require 'vendor/autoload.php';

  Class MailHelper {

    public static function send_email($parameters = []){

      //Create an instance; passing `true` enables exceptions
      $mail = new PHPMailer(true);
      $mail->CharSet = 'UTF-8';
    
      //Server settings
      $mail->SMTPDebug = ( isset($parameters['debug']) ? ( $parameters['debug'] == true ? SMTP::DEBUG_SERVER : false ) : false )  ;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = MAIL_CONFIG['SMTP_HOST']; //Set the SMTP server to send through
      $mail->SMTPAuth   = true; //Enable SMTP authentication
      $mail->Username   = MAIL_CONFIG['SMTP_USER']; //SMTP username
      $mail->Password   = MAIL_CONFIG['SMTP_PASSWORD']; //SMTP password
      //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = MAIL_CONFIG['SMTP_PORT']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      $mail->SMTPOptions = MAIL_CONFIG['SMTP_OPTIONS'];
      /*
      $mail->SMTPOptions =  [
        'ssl' => [
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        ],
      ]; 
      */

      //Recipients
      //$mail->setFrom('cartera@willsend.tech', 'Cartera De Domingo');
      $mail->setFrom(MAIL_CONFIG['SMTP_MAIL_FROM_ADDRESS'], MAIL_CONFIG['SMTP_MAIL_FROM_NAME']);

      if ( isset($parameters['destination']) ){
        foreach ( $parameters['destination'] as $email ){
          $mail->addAddress($email);     //Add a recipient
        }

      }      
   
      // cc
      if ( isset($parameters['copy']) ){
        foreach ( $parameters['copy'] as $email ){
          $mail->addCC($email);     //Add a recipient
        }
        
      }

      // Bcc
      if ( isset($parameters['hidden_copy']) ){
        foreach ( $parameters['hidden_copy'] as $email ){
          $mail->addBCC($email);     //Add a recipient
        }
        
      }
      
      // Attachments
      if ( isset($parameters['attachments']) ){
        foreach ( $parameters['attachments'] as $file ){
          if ( file_exists($file['path']) ) {
           $mail->addAttachment($file['path']);         //Add attachments
           //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
          }
           
        }
      }
      
      if ( isset($parameters['reply_to']) ){
        $mail->addReplyTo($parameters['reply_to']['email'], $parameters['reply_to']['name']);

      }else {
        //$mail->addReplyTo('william@willcode.tech', 'Willcode Sistemas - Suporte');

      }      
   
      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $parameters['subject'];
      $mail->Body    = $parameters['body'];
      $mail->AltBody = ( $parameters['alt_body'] ?? $parameters['body'] );

      if ( isset($parameters['send']) && $parameters['send'] == true )
        $mail->send();

      return true;
    }
  }