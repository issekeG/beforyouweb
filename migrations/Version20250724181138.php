<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724181138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(350) NOT NULL, client VARCHAR(255) NOT NULL, projet_at DATE NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_EAA5610E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation_image (id INT AUTO_INCREMENT NOT NULL, realisation_id INT DEFAULT NULL, url VARCHAR(350) NOT NULL, INDEX IDX_F9D6B0FB685E551 (realisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E12469DE2 FOREIGN KEY (category_id) REFERENCES realisation_category (id)');
        $this->addSql('ALTER TABLE realisation_image ADD CONSTRAINT FK_F9D6B0FB685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E12469DE2');
        $this->addSql('ALTER TABLE realisation_image DROP FOREIGN KEY FK_F9D6B0FB685E551');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE realisation_category');
        $this->addSql('DROP TABLE realisation_image');
    }
}
