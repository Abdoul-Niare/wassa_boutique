<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315172306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD wassa_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFCA66E36 FOREIGN KEY (wassa_user_id) REFERENCES wassa_user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DFCA66E36 ON commande (wassa_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFCA66E36');
        $this->addSql('DROP INDEX IDX_6EEAA67DFCA66E36 ON commande');
        $this->addSql('ALTER TABLE commande DROP wassa_user_id');
    }
}
