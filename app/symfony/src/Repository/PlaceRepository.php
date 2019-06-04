<?php

namespace App\Repository;

use App\Entity\Place;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlaceRepository extends ServiceEntityRepository
{
    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Place::class);
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function search(User $user): array
    {
        $queryBuilder = $this->createQueryBuilder('a');

        if ($user instanceof User) {
            $queryBuilder->andWhere('a.center = :center');
            $queryBuilder->setParameter('center', $user->getCenter());
        }

        $queryBuilder->andWhere('a.deletedAt IS NULL');

        return $queryBuilder->getQuery()->getResult();
    }
}
