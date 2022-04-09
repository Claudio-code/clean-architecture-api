<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\User as UserDomain;
use App\Infrastructure\Persistence\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<User> */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /** @throws Exception  */
    public function create(UserDomain $userDomain): User
    {
        $user = new User();
        $user->setName($userDomain->getName());
        $user->setEmail($userDomain->getEmail());
        $user->setRoles($userDomain->getRole());
        $user->setPassword($userDomain->getPassword());

        $this->beginTransaction();
        try {
            $this->persist($user);
        } catch (\Exception $exception) {
            $this->rollBack();
            throw $exception;
        }
        $this->commit();
        return $user;
    }
}
