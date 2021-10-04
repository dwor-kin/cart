<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211003155407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE catalog (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL UNIQUE, price FLOAT NOT NULL, INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB"); 
        $this->addSql("INSERT INTO catalog (title, price) VALUES ('The Godfather', 59.99)");
        $this->addSql("INSERT INTO catalog (title, price) VALUES ('Steve Jobs', 49.95)");
        $this->addSql("INSERT INTO catalog (title, price) VALUES ('The Return of Sherlock Holmes', 39.99)");
        $this->addSql("INSERT INTO catalog (title, price) VALUES ('The Little Prince', 29.99)");
        $this->addSql("INSERT INTO catalog (title, price) VALUES ('I Hate Myselfie!', 19.99)");
        $this->addSql("INSERT INTO catalog (title, price) VALUES ('The Trial', 9.99)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE catalog");    
    }
}
