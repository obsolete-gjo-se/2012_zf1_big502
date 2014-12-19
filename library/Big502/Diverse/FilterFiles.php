<?php

class Big502_Diverse_FilterFiles extends RecursiveFilterIterator {
    
    public static $FILTERS = array(
        '.project', 
        '.buildpath', 
        '.settings', 
        '.zfproject.xml', 
        '_works', 
        'data', 
        'docs', 
        'Proxy', 
        'Templates', 
        'images'
    );

    public function accept(){
        return ! in_array($this->current()->getFilename(), self::$FILTERS, true);
    }

}