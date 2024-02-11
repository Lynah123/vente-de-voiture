<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211110934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_product_details (color_id INT NOT NULL, product_details_id INT NOT NULL, INDEX IDX_124EAB297ADA1FB5 (color_id), INDEX IDX_124EAB29287D5809 (product_details_id), PRIMARY KEY(color_id, product_details_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE color_product_details ADD CONSTRAINT FK_124EAB297ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_product_details ADD CONSTRAINT FK_124EAB29287D5809 FOREIGN KEY (product_details_id) REFERENCES product_details (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_details DROP color');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE color_product_details DROP FOREIGN KEY FK_124EAB297ADA1FB5');
        $this->addSql('ALTER TABLE color_product_details DROP FOREIGN KEY FK_124EAB29287D5809');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE color_product_details');
        $this->addSql('ALTER TABLE product_details ADD color VARCHAR(255) NOT NULL');
    }
}
