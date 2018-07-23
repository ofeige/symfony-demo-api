<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180702091312 extends AbstractMigration
{
    public function up(Schema $schema) : void
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

    public function down(Schema $schema) : void
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
        $this->addSql('CREATE TABLE user_parents (user_id INT UNSIGNED NOT NULL, parent_user_id INT UNSIGNED NOT NULL, INDEX IDX_A55D0360A76ED395 (user_id), INDEX IDX_A55D0360D526A7D3 (parent_user_id), PRIMARY KEY(user_id, parent_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (article_id INT UNSIGNED AUTO_INCREMENT NOT NULL, article_author_user_id INT UNSIGNED DEFAULT NULL, article_title VARCHAR(255) NOT NULL, article_text MEDIUMTEXT NOT NULL, article_created_date DATETIME NOT NULL, INDEX IDX_23A0E66446FC05E (article_author_user_id), PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (comment_id INT UNSIGNED AUTO_INCREMENT NOT NULL, comment_user_id INT UNSIGNED DEFAULT NULL, comment_article_id INT UNSIGNED DEFAULT NULL, comment_text MEDIUMTEXT NOT NULL, INDEX IDX_9474526C541DB185 (comment_user_id), INDEX IDX_9474526CF0750CBC (comment_article_id), PRIMARY KEY(comment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments_likes (comment_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_1FCA91BF8697D13 (comment_id), INDEX IDX_1FCA91BA76ED395 (user_id), PRIMARY KEY(comment_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_parents ADD CONSTRAINT FK_A55D0360A76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE user_parents ADD CONSTRAINT FK_A55D0360D526A7D3 FOREIGN KEY (parent_user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66446FC05E FOREIGN KEY (article_author_user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C541DB185 FOREIGN KEY (comment_user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF0750CBC FOREIGN KEY (comment_article_id) REFERENCES article (article_id)');
        $this->addSql('ALTER TABLE comments_likes ADD CONSTRAINT FK_1FCA91BF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (comment_id)');
        $this->addSql('ALTER TABLE comments_likes ADD CONSTRAINT FK_1FCA91BA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
    }

    protected function downMysql(): void
    {
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF0750CBC');
        $this->addSql('ALTER TABLE comments_likes DROP FOREIGN KEY FK_1FCA91BF8697D13');
        $this->addSql('DROP TABLE user_parents');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comments_likes');
        $this->addSql('ALTER TABLE user CHANGE user_active user_active VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE useraddress CHANGE useraddress_type useraddress_type VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
    protected function upSqlite(): void
    {
        $this->addSql('CREATE TABLE user_parents (user_id INT UNSIGNED NOT NULL, parent_user_id INT UNSIGNED NOT NULL, PRIMARY KEY(user_id, parent_user_id))');
        $this->addSql('CREATE TABLE article (article_id INTEGER PRIMARY KEY AUTOINCREMENT, article_author_user_id INT UNSIGNED DEFAULT NULL, article_title VARCHAR(255) NOT NULL, article_text MEDIUMTEXT NOT NULL, article_created_date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE comment (comment_id INTEGER PRIMARY KEY AUTOINCREMENT, comment_user_id INT UNSIGNED DEFAULT NULL, comment_article_id INT UNSIGNED DEFAULT NULL, comment_text MEDIUMTEXT NOT NULL)');
        $this->addSql('CREATE TABLE comments_likes (comment_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, PRIMARY KEY(comment_id, user_id))');
    }

    protected function downSqlite(): void
    {
        $this->addSql('DROP TABLE user_parents');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comments_likes');
        $this->addSql('ALTER TABLE user CHANGE user_active user_active VARCHAR(50)');
        $this->addSql('ALTER TABLE useraddress CHANGE useraddress_type useraddress_type VARCHAR(50)');
    }
}
