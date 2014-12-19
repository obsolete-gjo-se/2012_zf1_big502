<?php

class Big502_Diverse_GetFiles {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    protected $folderfordb = array();

    public function storeFoldersInDB(){
        
        $root = '.';
        
        // $this->em = Zend_Registry::get('em');
        
        $folders = self::scanSystem($root);
        
                foreach ($folders as $file) {
                    printf(
                            '%s %s is a %s <br />',
                            str_repeat('&nbsp;', $folders->getDepth()),
                            $file,
                            $file->getType()
                    );
        
//         echo '<pre>';
//         print_r($folders);
//         echo '</pre>';
        
        // return $folders;
        
        // foreach ($folders as $folder) {
        // print_r($folders);
        // }
        
        // if(isset($folderfordb)) {
        // foreach ($folderfordb as $f) {
        // if(null != $f) {
        // $foldersdb = new Big502\Entity\FoldersEntity();
        // $foldersdb->name = $f;
        // $this->em->persist($foldersdb);
        // }
        // }
        
        // $this->em->flush();
        // }
    }
    
//     public function getFiles($directory) {
//         // Try to open the directory
//         if($dir = opendir($directory)) {
//             // Create an array for all files found
//             $tmp = Array();
    
//             // Add the files
//             while($file = readdir($dir)) {
//                 // Make sure the file exists
//                 if($file != "." && $file != ".." && $file[0] != '.') {
//                     // If it's a directiry, list all files within it
//                     if(is_dir($directory . "/" . $file)) {
//                         $tmp2 = getFiles($directory . "/" . $file);
//                         if(is_array($tmp2)) {
//                             $tmp = array_merge($tmp, $tmp2);
//                         }
//                     } else {
//                         array_push($tmp, $directory . "/" . $file);
//                     }
//                 }
//             }
    
//             // Finish off the function
//             closedir($dir);
//             return $tmp;
//         }
//     }
    
    // Example of use
   // print_r(getFiles('.')); // This will find all files in the current directory and all subdirectories

    }
    
    public function scanSystem($root){
        
//         $dir = new RecursiveIteratorIterator(
//                 new RecursiveDirectoryIterator('.' . DIRECTORY_SEPARATOR)
//         );
        
//         foreach ($dir as $file) {
//             printf(
//                     '%s %s is a %s <br />',
//                     str_repeat('&nbsp;', $dir->getDepth()),
//                     $file,
//                     $file->getType()
//             );
//         }
        
        
        $directory = '..';
        
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        
        return $it;
        
//         while($it->valid()) {
        
//             if (!$it->isDot()) {
//                 echo 'SubPathName: ' . $it->getSubPathName() . "<br />";
//                 echo 'SubPath:     ' . $it->getSubPath() . "<br />";
//                 echo 'Key:         ' . $it->key() . "<br /><br />";
//             }
        
//             $it->next();
//         }
        
//         $verzeichnis = array_slice(scanDir($root), 1);
        
//         $exclude_folders = self::excludeFolders();
//         $exclude_files = self::excludeFiles();
        
//         foreach ($verzeichnis as $element) {
//             if($element[0] != '.') {
//                 if(is_dir($root . '/' . $element)) {
//                     if(! in_array($root . '/' . $element, $exclude_folders, true)) {
//                             $folderArray[] = $element;
                        
                        
//                     }
//                 }
//                  else {
//                     if(! in_array($element, $exclude_files, true)) {
//                     $fileArray[] = $element;
//                     }
//                 }
//             }
//        }
        
//         if(isset($folderArray)) {
            
//             foreach ($folderArray as $folder) {
//                 $this->folderfordb[] = $root . '/' . $folder;
//                 $this->folderfordb[] .= self::scanSystem($root . '/' . $folder);
//             }
            // if(isset($folderfordb)) {
            // foreach ($folderfordb as $f) {
            // if(null != $f) {
            // $foldersdb = new Big502\Entity\FoldersEntity();
            // $foldersdb->name = $f;
            // $this->em->persist($foldersdb);
            // }
            // }
            // }
            
            // foreach ($folderArray as $folder) {
            // $foldersdb = new Big502\Entity\FoldersEntity();
            // $foldersdb->name = $root . '/' . $folder;
            // $foldersdb->name .= self::scanSystem($root . '/' . $folder);
            // $this->em->persist($foldersdb);
            
            // }
//         }
        
        // if(isset($fileArray)) {
        // foreach ($fileArray as $file) {
        // // $content .= $root . '/' . $file . '<br />';
        // }
        // }
        
        // echo '<pre>';
        // print_r($this->folderfordb);
        // echo '</pre>';
        
//        return $this->folderfordb;
    }
    
    // public function scanSystem2($root){
    
    // $content = '';
    
    // foreach (scandir($root) as $element) {
    // if($element[0] != '.') {
    // if(is_dir($root . '/' . $element)) {
    // $folderArray[] = $element;
    // } else {
    // $fileArray[] = $element;
    // }
    // }
    // }
    
    // if(isset($folderArray)) {
    // foreach ($folderArray as $folder) {
    // $content .= $folder. '<br />';
    // $content .= self::scanSystem($root . '/' . $folder);
    // }
    // }
    
    // if(isset($fileArray)) {
    // foreach ($fileArray as $file) {
    // $content .= $root . '/' . $file . '<br />';
    // }
    // }
    // return $content;
    // }
    
    private function storeFilesInDB(){

    }

    private function getFoldersFromDB(){

    }

    private function getFilesFromDB(){

    }

    private function compareFolders(){

    }

    private function compareFiles(){

    }

    private function excludeFolders(){
        // TODO in .txt auslagern
        $exclude_folders = array(
            '../_works', 
            '../data', 
            '../docs', 
            '../library/Big502/Entity/Proxy', 
            '../library/Big502/Templates', 
            '../public/images'
        );
        return $exclude_folders;
    }

    private function excludeFiles(){
        // TODO in .txt auslagern
        $exclude_files = array(
            'patch_central.css', 
            'phpunit.xml'
        );
        
        return $exclude_files;
    }

}