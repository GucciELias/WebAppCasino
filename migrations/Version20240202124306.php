<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202124306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_roulette ADD roulette_result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet_roulette ADD CONSTRAINT FK_715BE7806179DEDA FOREIGN KEY (roulette_result_id) REFERENCES roulette_result (id)');
        $this->addSql('CREATE INDEX IDX_715BE7806179DEDA ON bet_roulette (roulette_result_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_roulette DROP FOREIGN KEY FK_715BE7806179DEDA');
        $this->addSql('DROP INDEX IDX_715BE7806179DEDA ON bet_roulette');
        $this->addSql('ALTER TABLE bet_roulette DROP roulette_result_id');
    }
}
