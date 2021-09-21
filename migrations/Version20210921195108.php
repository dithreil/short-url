<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210921195108 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Add table: uri_entries';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE uri_entries (
            id INT AUTO_INCREMENT NOT NULL,
            long_uri VARCHAR(255) NOT NULL,
            short_uri VARCHAR(255) NOT NULL,
            expire_time DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE uri_entries');
    }
}
