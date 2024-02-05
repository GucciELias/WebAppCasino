<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121145313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roulette_result ADD roulette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE roulette_result ADD CONSTRAINT FK_B593676BC247C4 FOREIGN KEY (roulette_id) REFERENCES roulette (id)');
        $this->addSql('CREATE INDEX IDX_B593676BC247C4 ON roulette_result (roulette_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roulette_result DROP FOREIGN KEY FK_B593676BC247C4');
        $this->addSql('DROP INDEX IDX_B593676BC247C4 ON roulette_result');
        $this->addSql('ALTER TABLE roulette_result DROP roulette_id');
    }
}
