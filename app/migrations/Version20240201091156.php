<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201091156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_ad_like (ads_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4CA10CDCFE52BF81 (ads_id), INDEX IDX_4CA10CDCA76ED395 (user_id), PRIMARY KEY(ads_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_ad_like ADD CONSTRAINT FK_4CA10CDCFE52BF81 FOREIGN KEY (ads_id) REFERENCES ads (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ad_like ADD CONSTRAINT FK_4CA10CDCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ad_like DROP FOREIGN KEY FK_4CA10CDCFE52BF81');
        $this->addSql('ALTER TABLE user_ad_like DROP FOREIGN KEY FK_4CA10CDCA76ED395');
        $this->addSql('DROP TABLE user_ad_like');
    }
}
