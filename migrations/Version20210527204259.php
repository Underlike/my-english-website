<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210527204259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, score INT NOT NULL, INDEX IDX_D044D5D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vocabulary ADD category_id INT DEFAULT NULL, ADD english_wrong_one LONGTEXT NOT NULL, ADD english_wrong_two LONGTEXT NOT NULL, ADD english_wrong_three LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE vocabulary ADD CONSTRAINT FK_9099C97B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_9099C97B12469DE2 ON vocabulary (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE session');
        $this->addSql('ALTER TABLE vocabulary DROP FOREIGN KEY FK_9099C97B12469DE2');
        $this->addSql('DROP INDEX IDX_9099C97B12469DE2 ON vocabulary');
        $this->addSql('ALTER TABLE vocabulary DROP category_id, DROP english_wrong_one, DROP english_wrong_two, DROP english_wrong_three');
    }
}
