<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207121155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'ALTER TABLE user ADD active TINYINT(1) NOT NULL,
            ADD suspended TINYINT(1) NOT NULL,
            ADD deleted TINYINT(1) NOT NULL,
            ADD creation_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\',
            ADD active_since DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\',
            ADD suspended_since DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\',
            ADD deleted_since DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\',
            DROP gender,
            DROP address,
            DROP user_status,
            DROP user_suspended,
            DROP user_deleted'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'ALTER TABLE user ADD gender VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
            ADD address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
            ADD user_status TINYINT(1) NOT NULL,
            ADD user_suspended TINYINT(1) NOT NULL,
            ADD user_deleted TINYINT(1) NOT NULL,
            DROP active,
            DROP suspended,
            DROP deleted,
            DROP creation_date,
            DROP active_since,
            DROP suspended_since,
            DROP deleted_since'
        );
    }
}
