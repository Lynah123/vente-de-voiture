<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211084654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_details ADD type_id INT NOT NULL, ADD category_id INT NOT NULL, ADD brand_id INT NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product_details ADD CONSTRAINT FK_A3FF103AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE product_details ADD CONSTRAINT FK_A3FF103A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_details ADD CONSTRAINT FK_A3FF103A44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_A3FF103AC54C8C93 ON product_details (type_id)');
        $this->addSql('CREATE INDEX IDX_A3FF103A12469DE2 ON product_details (category_id)');
        $this->addSql('CREATE INDEX IDX_A3FF103A44F5D008 ON product_details (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_details DROP FOREIGN KEY FK_A3FF103AC54C8C93');
        $this->addSql('ALTER TABLE product_details DROP FOREIGN KEY FK_A3FF103A12469DE2');
        $this->addSql('ALTER TABLE product_details DROP FOREIGN KEY FK_A3FF103A44F5D008');
        $this->addSql('DROP INDEX IDX_A3FF103AC54C8C93 ON product_details');
        $this->addSql('DROP INDEX IDX_A3FF103A12469DE2 ON product_details');
        $this->addSql('DROP INDEX IDX_A3FF103A44F5D008 ON product_details');
        $this->addSql('ALTER TABLE product_details DROP type_id, DROP category_id, DROP brand_id, DROP created_at');
    }
}
