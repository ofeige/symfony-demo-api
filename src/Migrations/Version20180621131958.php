<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180621131958 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $platform = $this->connection->getDatabasePlatform()->getName();
        $this->abortIf(!in_array($platform, ['mysql', 'sqlite']),
            'Migration can only be executed safely on \'mysql\'.');
        switch ($platform) {
            case 'mysql':
                $this->upMysql();
                break;
            case 'sqlite':
                $this->upSqlite();
                break;
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $platform = $this->connection->getDatabasePlatform()->getName();
        $this->abortIf(!in_array($platform, ['mysql', 'sqlite']),
            'Migration can only be executed safely on \'mysql\'.');

        switch ($platform) {
            case 'mysql':
                $this->downMysql();
                break;
            case 'sqlite':
                $this->downSqlite();
                break;
        }
    }

    protected function upMysql(): void
    {
        $this->addSql('CREATE TABLE useraddress (useraddress_id INT UNSIGNED AUTO_INCREMENT NOT NULL, useraddress_user_id INT UNSIGNED DEFAULT NULL, useraddress_type ENUM(\'billing\',\'delivery\'), useraddress_name VARCHAR(255) NOT NULL, useraddress_street VARCHAR(255) NOT NULL, useraddress_zipcode VARCHAR(255) NOT NULL, useraddress_city VARCHAR(255) NOT NULL, useraddress_country VARCHAR(255) NOT NULL, INDEX IDX_912F933F4B77A6DB (useraddress_user_id), PRIMARY KEY(useraddress_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_username VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, user_forename VARCHAR(255) NOT NULL, user_surname VARCHAR(255) NOT NULL, user_password VARCHAR(255) NOT NULL, user_password_salt VARCHAR(255) NOT NULL, user_active ENUM(\'yes\',\'no\'), user_created DATETIME NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE useraddress ADD CONSTRAINT FK_912F933F4B77A6DB FOREIGN KEY (useraddress_user_id) REFERENCES user (user_id)');
    }

    protected function downMysql(): void
    {
        $this->addSql('ALTER TABLE useraddress DROP FOREIGN KEY FK_912F933F4B77A6DB');
        $this->addSql('DROP TABLE useraddress');
        $this->addSql('DROP TABLE user');
    }
    protected function upSqlite(): void
    {
        $this->addSql('CREATE TABLE useraddress (useraddress_id INTEGER PRIMARY KEY AUTOINCREMENT, useraddress_user_id INT UNSIGNED DEFAULT NULL, useraddress_type VARCHAR(16), useraddress_name VARCHAR(255) NOT NULL, useraddress_street VARCHAR(255) NOT NULL, useraddress_zipcode VARCHAR(255) NOT NULL, useraddress_city VARCHAR(255) NOT NULL, useraddress_country VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user (user_id INTEGER PRIMARY KEY AUTOINCREMENT, user_username VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, user_forename VARCHAR(255) NOT NULL, user_surname VARCHAR(255) NOT NULL, user_password VARCHAR(255) NOT NULL, user_password_salt VARCHAR(255) NOT NULL, user_active VARCHAR(4), user_created DATETIME NOT NULL)');
    }

    protected function downSqlite(): void
    {
        $this->addSql('DROP TABLE useraddress');
        $this->addSql('DROP TABLE user');
    }
}
