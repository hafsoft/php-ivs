<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 8:31 PM
 */
namespace org\haf\ivs\tool;
class Security
{
    public static function generateSalt($len = 5)
    {
        /** @noinspection SpellCheckingInspection */
        static $chr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=+_)(*^%$@!`~[]{};:,.";
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $result .= $chr[mt_rand(0, strlen($chr))];
        }
        return $result;
    }
}