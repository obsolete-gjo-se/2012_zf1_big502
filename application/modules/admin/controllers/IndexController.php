<?php

class Admin_IndexController extends Big502_Controller_BaseController {
    
    protected $em = null;

    public function indexIndexAction(){
        
        $resourceAction = 'resource-action';
        $filterChain = new Zend_Filter();
        $filterChain->addFilter(new Zend_Filter_Word_DashToCamelCase());
        // $filterChain->addFilter(new Zend_Filter_Word_CamelCaseToDash());
        // $filterChain->addFilter(new Zend_Filter_StringToLower());
        
        $chain = $filterChain->filter($resourceAction);
        echo 'versuch ' . lcfirst($chain);
    }

    public function sessionTestAction(){
        
        // schreiben von Daten in SessionVariablen:
        $ns = new Zend_Session_Namespace('Namespace');
        
        $ns->thisIsSession = "Speicher1";
        $ns->nameOfSession = "MySession115155";
        $ns->foo = 10;
        
        // auslesen von Daten aus Sessionvariablen:
        $ns = new Zend_Session_Namespace('Namespace');
        
        echo "ist Session: " . $ns->thisIsSession . "<br />";
        echo "SessionName: " . $ns->nameOfSession . "<br />";
        echo "foo: " . $ns->foo . '<br /><br />';
        
        print 'Includepah: ' . get_include_path() . '<br />';
        
        echo 'ServerName:' . $_SERVER['SERVER_NAME'];
        
        echo ("<pre>");
        print_r($_SERVER);
        echo ("SERVER = " . $_SERVER['SERVER_NAME']);
        echo ("</pre>");
    }

    public function showPhpInfoAction(){
        echo phpinfo();
    }

    public function showAllFilesAction($folder = '..'){
        
        $content = '<table>';
        
        foreach (scandir($folder) as $file) {
            if($file[0] != '.') { // Versteckte Dateien nicht anzeigen
                if(is_dir($folder . '/' . $file)) {
                    $folderArray[] = $file;
                } else {
                    $fileArray[] = $file;
                }
            }
        }
        
        // Erst die Ordner ausgeben
        if(isset($folderArray)) {
            foreach ($folderArray as $row) {
                // rekursive Funktion
                $content .= self::showAllFilesAction($folder . '/' . $row);
            }
        }
        if(isset($fileArray)) {
            foreach ($fileArray as $row) {
                $content .= '<tr><td>' . $folder . '/' . $row . '</td><td>' .
                         mb_detect_encoding($row) . '</td></tr>';
                    
                    }
                }
                // $content .= '</table>';
                echo $content;
            }
        
        }