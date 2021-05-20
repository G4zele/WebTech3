<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518170519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT NOT NULL, user_rel_id INT NOT NULL, title VARCHAR(255) NOT NULL, annotation VARCHAR(255) NOT NULL, content VARCHAR(2040) NOT NULL, views INT NOT NULL, art_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E662B58BAF0 ON article (user_rel_id)');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, user_rel_id INT NOT NULL, article_rel_id INT NOT NULL, text VARCHAR(510) NOT NULL, comm_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C2B58BAF0 ON comment (user_rel_id)');
        $this->addSql('CREATE INDEX IDX_9474526C24CD364D ON comment (article_rel_id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E662B58BAF0 FOREIGN KEY (user_rel_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C2B58BAF0 FOREIGN KEY (user_rel_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C24CD364D FOREIGN KEY (article_rel_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C24CD364D');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
    }
}
