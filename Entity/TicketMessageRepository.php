<?php

namespace Hackzilla\Bundle\TicketBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;

/**
 * TicketMessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketMessageRepository extends EntityRepository
{
    /**
     * Lookup status code
     * 
     * @param object $translator
     * @param string $statusStr
     * 
     * @return integer
     */
    public function getTicketStatus($translator, $statusStr)
    {
        static $statuses = false;
        
        if ($statuses === false) {
            $statuses = array();
            
            foreach (TicketMessage::$statuses as $id => $value) {
                $statuses[$id] = $translator->trans($value);
            }
        }
        
        return \array_search($statusStr, $statuses);
    }
}
