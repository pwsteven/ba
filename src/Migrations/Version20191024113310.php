<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024113310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_details (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, house_name_number VARCHAR(255) DEFAULT NULL, street_address VARCHAR(255) DEFAULT NULL, street_address2 VARCHAR(255) DEFAULT NULL, town_city VARCHAR(255) DEFAULT NULL, county VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, email_address VARCHAR(255) DEFAULT NULL, mobile_telephone_number VARCHAR(255) DEFAULT NULL, completed TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_E8092A0BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL, CHANGE surname surname VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE photo_id photo_id VARCHAR(255) DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE app_started app_started TINYINT(1) DEFAULT NULL, CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT NULL, CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT NULL, CHANGE app_completed app_completed TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contact_details');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE middle_name middle_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE surname surname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE photo_id photo_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE app_started app_started TINYINT(1) DEFAULT \'NULL\', CHANGE app_completed app_completed TINYINT(1) DEFAULT \'NULL\', CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT \'NULL\'');
    }
}
