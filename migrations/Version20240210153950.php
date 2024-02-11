<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240210153950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand CHANGE supplier_id supplier_id INT NOT NULL');
        $this->addSql('ALTER TABLE productDetailsCHANGE brand_id brand_id INT NOT NULL, CHANGE type_id type_id INT NOT NULL, CHANGE category_id category_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand CHANGE supplier_id supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE productDetailsCHANGE type_id type_id INT DEFAULT NULL, CHANGE brand_id brand_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL');
    }
}
