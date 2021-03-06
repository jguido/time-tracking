<?php

namespace dElt4\TimeBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Types\Type;
use Sonata\UserBundle\Model\User;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    /**
     * Return events that matches to $begin && $end
     * $end date should be exclude
     *
     * @param \DateTime $day
     * @param User      $user
     */
    public function getEvents(\DateTime $day, User $user)
    {

        $qb = $this->createQueryBuilder('e');

        return $qb
            ->where('YEAR(e.day) = :year')
            ->andWhere('MONTH(e.day) = :month')
            ->andWhere(
                $qb->expr()->eq('e.user', $user->getId())
            )
            ->setParameter('year', $day->format('Y'))
            ->setParameter('month', $day->format('m'))
            ->orderBy('e.day')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param integer   $userId
     * @param string    $type
     * @param \DateTime $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserDateAndType($userId, $type, \DateTime $date)
    {
        $qb = $this->createQueryBuilder('e');

        return $qb
            ->where('YEAR(e.day) = :year')
            ->andWhere('MONTH(e.day) = :month')
            ->andWhere('DAY(e.day) = :day')
            ->andWhere('e.user = :user')
            ->andWhere('e.type = :type')
            ->setParameter('year', $date->format('Y'))
            ->setParameter('month', $date->format('m'))
            ->setParameter('day', $date->format('d'))
            ->setParameter('user', $userId)
            ->setParameter('type', $type, Type::STRING)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param integer   $projectId
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByProjectFromTo($projectId, \DateTime $from, \DateTime $to)
    {
        $qb = $this->createQueryBuilder('e');

        return $qb
            ->where('e.day BETWEEN :from AND :to')
            ->andWhere('e.project = :project')
            ->setParameter('from'    , $from->format('Y-m-d'))
            ->setParameter('to'      , $to->format('Y-m-d')  )
            ->setParameter('project' , $projectId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array  $data
     * @param User   $user
     * @param string $type
     * @return Event
     */
    public function findOrCreate(array $data, User $user, $type)
    {
        if (isset($data['id']) && '' !== $data['id']) {
            $event = $this->find($data['id']);
        } else {
            $testEvent = $this->findOneByUserDateAndType(
                $user->getId(),
                $type,
                \DateTime::createFromFormat('Y-m-d', $data['date'])
            );

            if ($testEvent) {
                $event = $testEvent;
            } else {
                $event = new Event();
                $event
                    ->setDay(\DateTime::createFromFormat('Y-m-d', $data['date']))
                    ->setType($type);
                $this->_em->persist($event);
            }
        }
        if (!$event->getLocked()) {
            $project = $this->_em->getRepository('dElt4TimeBundle:Project')->find($data['project']);

            $event
                ->setProject($project)
                ->setUser($user);

            $this->_em->flush($event);
        }

        return $event;
    }
}
