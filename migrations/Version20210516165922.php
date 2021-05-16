<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516165922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cita ADD sala_id INT NOT NULL');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A62C51CDF3F FOREIGN KEY (sala_id) REFERENCES sala (id)');
        $this->addSql('CREATE INDEX IDX_3E379A62C51CDF3F ON cita (sala_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A62C51CDF3F');
        $this->addSql('DROP INDEX IDX_3E379A62C51CDF3F ON cita');
        $this->addSql('ALTER TABLE cita DROP sala_id');
    }
}
