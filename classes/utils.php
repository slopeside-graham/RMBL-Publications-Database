<?php

namespace PUBS {

    use PUBS\PUBS_Base as PUBS_Base;

    class Utils extends PUBS_Base
    {
        public static $db;

        const FIRSTKEY = "iirllYKjMay317sHom8qjGmWKpYddqTrqNQ4KkJe890=";
        const SECONDKEY = "FbV0+9FkxVm5MYJ8OTVVvNqq9pbvQiF2AcKrU27kDz6m7wgLLRCN1+P2OjYPG8EhI6vg7r0uqFskcSFr+K4S+Q==";

        public static function encrypt($toencrypt)
        {
            try {
                $first_key = base64_decode(self::FIRSTKEY);
                $second_key = base64_decode(self::SECONDKEY);

                $method = "aes-256-cbc";
                $iv_length = openssl_cipher_iv_length($method);
                $iv = openssl_random_pseudo_bytes($iv_length);

                $first_encrypted = openssl_encrypt($toencrypt, $method, $first_key, OPENSSL_RAW_DATA, $iv);
                $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

                $output = base64_encode($iv . $second_encrypted . $first_encrypted);
                return $output;
            } catch (\Exception $e) {
            }
        }

        public static function decrypt($todecrypt)
        {
            try {
                $first_key = base64_decode(self::FIRSTKEY);
                $second_key = base64_decode(self::SECONDKEY);
                $mix = base64_decode($todecrypt);

                $method = "aes-256-cbc";
                $iv_length = openssl_cipher_iv_length($method);

                $iv = substr($mix, 0, $iv_length);
                $second_encrypted = substr($mix, $iv_length, 64);
                $first_encrypted = substr($mix, $iv_length + 64);

                $todecrypt = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);
                $second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

                if (hash_equals($second_encrypted, $second_encrypted_new))
                    return $todecrypt;
                else
                    return false;
            } catch (\Exception $e) {
            }
            return false;
        }
        public static function getencryptedsetting($key)
        {
            try {
                $option = get_option($key);
                if ($option != false) {
                    $value =  self::decrypt($option);
                    return $value;
                } else return "";
            } catch (\Exception $e) {
            }
            return "";
        }
        public static function getunencryptedsetting($key)
        {
            return (get_option($key));
        }

        public static function getPagingSQL($page = null, $pageSize = null)
        {
            $pagingSql = "";
            if (isset($page) && $page > 0 && isset($pageSize) && $pageSize) {
                $offset = ($page - 1) * $pageSize;
                $limit = $pageSize;
                $pagingSql = " LIMIT " . $offset . ", " . $limit . ";";
            }
            return $pagingSql;
        }
    }
}
