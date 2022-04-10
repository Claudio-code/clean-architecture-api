<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409232449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO users (id, name, email, created_at, updated_at, password, roles) VALUES (1, "claudio", "claudio@gmail.com", "2022-04-09 18:28:31", "2022-04-09 18:28:31", "$2y$13$H.vAYaPFASoLZ1z5tnfr8eAETRNSoQezh1pAl5lGMWiM4K2M./9I2", "ROLE_ADMIN");');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
