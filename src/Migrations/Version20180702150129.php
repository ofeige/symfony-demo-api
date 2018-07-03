<?php /** @noinspection SqlResolve */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180702150129 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item_attribute (item_attribute_id INT UNSIGNED AUTO_INCREMENT NOT NULL, item_attribute_item_id INT UNSIGNED DEFAULT NULL, item_attribute_key VARCHAR(255) NOT NULL, item_attribute_value VARCHAR(255) NOT NULL, INDEX IDX_F6A0F90B14C3646C (item_attribute_item_id), PRIMARY KEY(item_attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_group (item_group_id INT UNSIGNED AUTO_INCREMENT NOT NULL, item_group_name VARCHAR(255) NOT NULL, PRIMARY KEY(item_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (item_id INT UNSIGNED AUTO_INCREMENT NOT NULL, item_item_group_id INT UNSIGNED DEFAULT NULL, item_name VARCHAR(255) NOT NULL, INDEX IDX_1F1B251E7EF5B957 (item_item_group_id), PRIMARY KEY(item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_attribute ADD CONSTRAINT FK_F6A0F90B14C3646C FOREIGN KEY (item_attribute_item_id) REFERENCES item (item_id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E7EF5B957 FOREIGN KEY (item_item_group_id) REFERENCES item_group (item_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E7EF5B957');
        $this->addSql('ALTER TABLE item_attribute DROP FOREIGN KEY FK_F6A0F90B14C3646C');
        $this->addSql('DROP TABLE item_attribute');
        $this->addSql('DROP TABLE item_group');
        $this->addSql('DROP TABLE item');
    }
}
