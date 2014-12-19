<?php

class Big502_View_Helper_TickHelper extends Zend_View_Helper_Abstract
{
    public function tickHelper($value = 0)
    {
        if($value == 1)
            echo 'ja';
        else
            echo 'nein';
    }
}