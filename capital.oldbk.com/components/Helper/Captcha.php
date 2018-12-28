<?php
namespace components\Helper;

use Guzzle\Http\Client;
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 10.11.2015
 */
class Captcha
{
    protected static $public_key = '6Lf2mhATAAAAACyA03v68UZiwMm600Tb5xtkuc3i';
    protected static $private_key = '6Lf2mhATAAAAAN7VBXjECByhQyEe36GeuY6v28li';
    protected static $field = 'g-recaptcha-response';

    public static function render()
    {
        return '<script src="https://www.google.com/recaptcha/api.js?hl=ru"></script><div style="width:304px;margin:0 auto;" class="g-recaptcha" data-sitekey="'.self::$public_key.'"></div>';
    }

    public static function validate()
    {
        if(!isset($_POST[self::$field]))
            return false;

        $client = new Client();
        $request = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            null,
            array(
                'secret' => self::$private_key,
                'response' => $_POST[self::$field]
            )
        );
        $response = $request->send();

        $body = json_decode($response->getBody(true));

        return $body->success;
    }
}