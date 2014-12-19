<?php
/**
 * Various string utilities
 *
 * @category CC
 * @package CC
 * @copyright Code-Complex
 */

class Big502_Inflector_Inflector
{
    /**
     * Converts a controller's name to a resource name
     * 
     * Ex: MyExampleController => my-example
     * 
     * @param string $string 
     * @access public
     * @return string
     */
    public static function convertControllerName($string)
    {
        $string = substr($string, 0, -10);
        return self::camelCaseToDash($string);
    }
    
    /**
     * Converts an action's name to a privilege name
     * 
     * Ex: myExampleAction => my-example
     * 
     * @param string $string 
     * @access public
     * @return string
     */
    public static function convertActionName($string)
    {
        $string = substr($string, 0, -6);
        return self::camelCaseToDash($string);
    }
    
    /**
     * Convers a camelCasedString to lower cased string with
     * words separated by dashes
     *
     * Ex: myCamelCasedString => my-camel-cased-string
     * 
     * @param string $string 
     * @access public
     * @return string
     */
    public static function camelCaseToDash($string)
    {
        $string = preg_replace('/([A-Z]+)([A-Z])/','$1-$2', $string);
        $string = preg_replace('/([a-z])([A-Z])/', '$1-$2', $string);
        
        return strtolower($string);
    }
    
    /**
     * Converts a dashed or underscored string to a humanly readable
     * one. Ex:
     * my-action-controller => My action controller
     * 
     * @param mixed $string 
     * @access public
     * @return void
     */
    public static function humanize($string)
    {
        return ucfirst(str_replace(array('_', '-'), ' ', $string));
    }
    
    /**
     * Computes a slug of the given string
     * 
     * @param mixed $string 
     * @access public
     * @return string
     */
    public static function slug($string)
    {
        $string = preg_replace('/([^a-z0-9]){1,}/', '-', strtolower($string));
        return $string;
    }
    
    /**
     * Returns an array of email address extracted from
     * the given string
     * 
     * @param string $emailString String containing email address
     * @access public
     * @return array Array containing email addresses
     */
    public static function extractEmailAddresses($emailString)
    {
        $emailRegex = '/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i';
        preg_match_all($emailRegex, $emailString, $matches);
        
        return $matches[0];
    }
    
    /**
     * Parse a string into a key => value array.
     * 
     * Eg: key::value|key::value
     * 
     * @param string $expression 
     * @return array
     */
    public static function parseParamString($expression)
    {
        $rulesArray = array();
        
        // Split on rule boundry |
        $rules = explode('|', $expression);
        
        foreach($rules as $rule)
        {
            // Split on rule key value ::
            $ruleKeyValue = explode('::', $rule);
            
            if(count($ruleKeyValue) == 2)
                $rulesArray[$ruleKeyValue[0]] = $ruleKeyValue[1];
        }
        
        return $rulesArray;
    }
    
    /**
     * Parse a string into an array. Array notation is as follows:
     * {key::value|key::value}{key::value}
     * 
     * @param string $expression
     * @return array
     */
    public static function parseParamStringArray($expression)
    {
        $ret = array();
        $pattern = '/[{][a-z:\\|@\\._,\-0-9]*[}]/i';
        
        // Get all action sets
        preg_match_all($pattern, $expression, $actions);
        
        if(count($actions[0]))
        {
            foreach($actions[0] as $action)
            {
                // Remove action boundries
                $action = str_replace('{', '', $action);
                $action = str_replace('}', '', $action);
                
                // Parse action string
                $tmp = Big502_Inflector_Inflector::parseParamString($action);
                if(count($tmp))
                    $ret[] = $tmp;
            }
        }
        
        return $ret;
    }
}