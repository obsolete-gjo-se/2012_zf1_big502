<?php
namespace Big502\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class RulesRepository extends EntityRepository {

    /**
     * Creates an associative array to be used with the form
     * to populate the check boxes.
     *
     * Example array structure:
     * array[controller id][action id] = isAllowed
     *
     * @param $roleId integer
     *            Role ID
     * @return array
     */
    public function getRulesForRole($roleId){
        $roleRules = array();
        
        // TODO DQL Vorlage?!
        $dql = 'SELECT r FROM Big502\Entity\RulesEntity r
                        JOIN r.role rl
                        WHERE rl.id = ?1';
        $rules = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $roleId)
            ->getResult();
        
        foreach ($rules as $rule) {
            // TODO bringt Fehler, sollte nach Muster rule_1_2 Ergebnis bringen!
            $roleRules[$rule->resourceAction->resourceController][$rule->resourceAction] = ($rule->allow == true ? '1' : '0');
        }
        
        return $roleRules;
    }

    public function findAllRules(){
        
        $dql = 'SELECT ru FROM Big502\Entity\RulesEntity ru
                   JOIN ru.resourceAction a
                   JOIN ru.role ro
                   ORDER BY
                       a.id ASC,
                       ro.name ASC';
        
        $rules = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
        
        return $rules;
    }
}