<?php


class Admin_Verify {

    public static function checkEmail($email) {
        if (!strstr($email, '@')) return FALSE;
        return TRUE;
    }
    
}