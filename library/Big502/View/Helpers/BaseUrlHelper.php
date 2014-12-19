<?php

class Big502_View_Helper_BaseUrlHelper {

    public function baseUrlHelper(){
        
        //  TODO alte Variante mit Fehlermeldung
        // $baseUrl = 'http://' . $_SERVER['SERVER_NAME'];
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
        
        return $baseUrl;
    }

}