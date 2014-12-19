<?php

class Admin_Model_Forms_RolesRulesForm extends Big502_Form_BaseForm {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * Overrides the constructor
     *
     * @param $em Doctrine\ORM\EntityManager           
     * @param $options array           
     */
    public function __construct(Doctrine\ORM\EntityManager $em, $options = null){
        
        // TODO Zend_Form RF
        // ???????????? - groups-flippers??? - kann auch ganz raus?! -
        // Namensgleichheit im Quellcode
        $this->setAttrib('id', 'roles-rules');
        
        parent::__construct($options);
        $this->_em = $em;
        
        $dql = 'SELECT c FROM Big502\Entity\ResourceControllersEntity c
                    ORDER BY c.name ASC';
        $resourceController = $this->_em->createQuery($dql)->getResult();
        
        foreach ($resourceController as $controller) {
            
            $displayGroup = array();
            $resourceActions = $controller->resourceActions;
            
            if(count($resourceActions)) {
                foreach ($controller->resourceActions as $action) {
                    
                    $checkbox = new Zend_Form_Element_Checkbox(
                            'rule_' . $controller->id . '_' . $action->id);
                    $checkbox->setOptions(
                            array(
                                'label' => '/' . $controller->name . '/' . $action->name . '/ (' .
                                         $action->description . ')'
                            ));
                    
                    $this->addElement($checkbox);
                    $displayGroup[] = $checkbox->getName();
                }
                
                $displayGroupTitle = ucfirst($controller->name) . ' (' . $controller->description .
                         ')';
                        $this->addDisplayGroup($displayGroup, $controller->name, 
                                array(
                                    'legend' => $displayGroupTitle
                                ));
                    }
                }
                
                // Add the role id
                $roleId = new Zend_Form_Element_Hidden('roleId');
                $roleId->setOptions(
                        array(
                            'validators' => array(
                                new Zend_Validate_Regex('/^\d*$/')
                            )
                        ));
                $this->addElement($roleId);
                
                // Add the submit button
                $submit = new Zend_Form_Element_Submit('submit');
                $submit->setLabel('Save permissions')->setRequired(true);
                
                $this->addElement($submit);
            }

            /**
             * Overrides populate() in Zend_Form
             *
             * @param $data array           
             * @access public
             * @return void
             */
//             public function populate($data, $id){
//                 $parsed = array(
//                     'role_id' => $id
//                 );
                
//                 foreach ($data as $controllerId => $action) {
//                     foreach ($action as $actionId => $allow) {
//                         $parsed['rule_' . $controllerId . '_' . $actionId] = $allow;
//                     }
//                 }
                
//                 parent::populate($parsed);
//             }

            /**
             * Overrides getValues() in Zend_Form
             *
             * @access public
             * @return array
             */
//             public function getValues(){
//                 $raw = parent::getValues();
                
//                 $values = array(
//                     'roleId' => $raw['roleId'], 
//                     'rule' => array()
//                 );
                
//                 foreach ($raw as $key => $value) {
//                     if(preg_match('/^rule_([0-9]{1,})_([0-9]{1,})$/', $key)) {
//                         $parts = explode('_', $key);
//                         if(! isset($values['rule'][$parts[1]])) {
//                             $values['rule'][$parts[1]] = array();
//                         }
                        
//                         $values['rule'][$parts[1]][$parts[2]] = $value;
//                     }
//                 }
                
//                 return $values;
//             }
        }