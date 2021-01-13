<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113071454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD post_title_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB5720E1C FOREIGN KEY (post_title_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_9474526CB5720E1C ON comment (post_title_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB5720E1C');
        $this->addSql('DROP INDEX IDX_9474526CB5720E1C ON comment');
        $this->addSql('ALTER TABLE comment DROP post_title_id');
    }
}
