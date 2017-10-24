<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PotRepository extends EntityRepository
{
    public function getAvgMoistureByDay($id)
    {
            $queryAvgScore = $this->createQueryBuilder('p')
            	->join('p.moistures', 'm')
            	->addSelect('m')
				->select("avg(m.value) as avg_moisture, SUBSTRING(m.date, 9, 2) as day")
				->where('p.id = :id')
				->andWhere('m.date >= :dateStart')
				->andWhere('m.date <= :dateEnd')
				->setParameter('id', $id)
				->setParameter('dateStart', date("Y-m-d 00:00:00", strtotime("first day of this month")))
				->setParameter('dateEnd', date("Y-m-d 00:00:00", strtotime("last day of this month")))
				->groupBy('day')
				->getQuery();

			return $queryAvgScore->getResult();
    }
}