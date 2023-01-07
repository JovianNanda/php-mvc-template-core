<?php

namespace jnanda\jnandaphpmvc\middlewares;

use jnanda\jnandaphpmvc\Application;

class Auth
{
    protected const TOKEN_LABEL = "token";
    
    public function token($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    public function getCSRF()
    {
        if (empty(Application::$app->session->get(self::TOKEN_LABEL))) {
            Application::$app->session->set(self::TOKEN_LABEL, $this->token(40));
        }
        return $this->csrf();
    }

    public function csrf(){
        return password_hash(Application::$app->session->get(self::TOKEN_LABEL), PASSWORD_DEFAULT);
    }


    public function regenerate(){
        Application::$app->session->remove(self::TOKEN_LABEL);
        (new Auth)->getCSRF();
    }


    public function check($token){
        if (Application::$app->session->get(self::TOKEN_LABEL)) {
            if (password_verify(Application::$app->session->get(self::TOKEN_LABEL), $token)) {
                return true;
            } else {
                return false;
            }
            } else {
                return false;
            }
        }
    }