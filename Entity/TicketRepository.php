<?php

namespace Hackzilla\Bundle\TicketBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
    public function getTicketList($userManager, $ticketStatus)
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.lastMessage', 'DESC');

        switch($ticketStatus)
        {
            case TicketMessage::STATUS_CLOSED:
                $query
                    ->andWhere('t.status = :status')
                    ->setParameter('status', TicketMessage::STATUS_CLOSED);
                break;

            case TicketMessage::STATUS_OPEN:
            default:
                $query
                    ->andWhere('t.status != :status')
                    ->setParameter('status', TicketMessage::STATUS_CLOSED);
        }
        
        $user = $userManager->getCurrentUser();

        if (\is_object($user) && !$userManager->hasRole($user, 'ROLE_TICKET_ADMIN')) {
            $query
                ->andWhere('t.userCreated = :userId')
                ->setParameter('userId', $user->getId());
        }

        return $query;
    }
}
