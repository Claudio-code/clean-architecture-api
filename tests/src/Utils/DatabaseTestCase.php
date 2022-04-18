<?php

namespace App\Tests\src\Utils;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseTestCase extends KernelTestCase
{
    protected ManagerRegistry $entityManager;
    protected PaginatorInterface $paginator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        if ('test' !== $kernel->getEnvironment()) {
            throw new LogicException('Execution only in Test environment possible!');
        }

        $this->initDatabase();
        $this->paginator = $kernel->getContainer()->get('knp_paginator');
        $this->entityManager = $kernel->getContainer()->get('doctrine');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->dowDatabase();
    }

    final protected function initDatabase(): void
    {
        exec('php bin/console doctrine:schema:update --force --env=test');
    }

    final protected function dowDatabase(): void
    {
        exec('php bin/console doctrine:schema:drop  --force --env=test');
    }
}
