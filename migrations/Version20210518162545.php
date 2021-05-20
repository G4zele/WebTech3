<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518162545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, userrel_id INT NOT NULL, title VARCHAR(255) NOT NULL, annotation VARCHAR(255) NOT NULL, content VARCHAR(2040) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, views INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E6626F0B609 ON article (userrel_id)');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, userrel_id INT NOT NULL, articlerel_id INT DEFAULT NULL, text VARCHAR(510) NOT NULL, datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C26F0B609 ON comment (userrel_id)');
        $this->addSql('CREATE INDEX IDX_9474526CB3853F40 ON comment (articlerel_id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6626F0B609 FOREIGN KEY (userrel_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C26F0B609 FOREIGN KEY (userrel_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB3853F40 FOREIGN KEY (articlerel_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CB3853F40');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
    }
}
