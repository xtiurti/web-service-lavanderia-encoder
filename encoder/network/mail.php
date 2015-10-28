<?php

class Mail {

    /**
     *
     * @var string
     */
    static $host;

    /**
     *
     * @var string
     */
    static $username;

    /**
     *
     * @var string
     */
    static $password;

    /**
     *
     * @var string
     */
    static $name;

    /**
     *
     * @var mail
     */
    static $mail;

    /**
     * Método construtor do frameword.
     */
    static function init() {
        init('mail');
        self::set_mailer();
    }

    /**
     * @return void
     */
    static function set_mailer() {
        require CORE . 'authoritarian' . DS . 'mailer' . DS . 'PHPMailer-master' . DS . 'PHPMailerAutoload.php';

        self::$mail = new \PHPMailer();
        self::$mail->isHTML(true);
        self::$mail->CharSet = 'UTF-8';
        self::$mail->Port = 587;
        
        self::$mail->isSMTP();
        self::$mail->SMTPDebug = 0;
        self::$mail->SMTPAuth = true;
        # self::$mail->SMTPSecure = 'tls';

        self::$mail->Host = self::$host;
        self::$mail->Username = self::$username;
        self::$mail->Password = self::$password;

        self::$mail->From = self::$username;
        self::$mail->FromName = self::$name;

        ## message
        # self::$mail->Subject;
        # self::$mail->body;
        ## send
        # self::$mail->addAddress($to, 'Liv Web Contato');
        # return self::$mail->send();
    }

    /**
     * 
     * @param type $to
     * @param type $subject
     * @param type $message
     * @return boolean e-mail enviando ou não
     */
    static function send($to, $subject, $message) {
        self::$mail->addAddress($to, static::$name);
        self::$mail->Subject = $subject;
        self::$mail->Body = $message;
        return self::$mail->send();
    }
    
    /**
     * Envia um e-mail com o conteúdo de uma View.
     * 
     * @param <string> $to
     * @param <string> $subject
     * @param <string> $view
     * @param <array> $data
     */
    static function by_view($to, $subject, $view, $data = array()) {
        return Mail::send($to, $subject, view($view, $data, 'email'));
    }

}
