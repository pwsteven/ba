<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126163918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file_reference (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, filename VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, original_file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_20ACF665A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_reference ADD CONSTRAINT FK_20ACF665A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT NULL, CHANGE street_address street_address VARCHAR(255) DEFAULT NULL, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT NULL, CHANGE town_city town_city VARCHAR(255) DEFAULT NULL, CHANGE county county VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE email_address email_address VARCHAR(255) DEFAULT NULL, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL, CHANGE surname surname VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE pro_claim_reference pro_claim_reference INT DEFAULT NULL, CHANGE app_started app_started TINYINT(1) DEFAULT NULL, CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT NULL, CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT NULL, CHANGE app_bacorrespondence app_bacorrespondence TINYINT(1) DEFAULT NULL, CHANGE app_futher_correspondence app_futher_correspondence TINYINT(1) DEFAULT NULL, CHANGE app_complaints app_complaints TINYINT(1) DEFAULT NULL, CHANGE app_financial_loss app_financial_loss TINYINT(1) DEFAULT NULL, CHANGE app_reimbursements app_reimbursements TINYINT(1) DEFAULT NULL, CHANGE app_credit_monitoring app_credit_monitoring TINYINT(1) DEFAULT NULL, CHANGE app_emotional_distress app_emotional_distress TINYINT(1) DEFAULT NULL, CHANGE app_completed app_completed TINYINT(1) DEFAULT NULL, CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE file_reference');
        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address street_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE town_city town_city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE county county VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE postcode postcode VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email_address email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE middle_name middle_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE surname surname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE app_started app_started TINYINT(1) DEFAULT \'NULL\', CHANGE app_completed app_completed TINYINT(1) DEFAULT \'NULL\', CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE app_bacorrespondence app_bacorrespondence TINYINT(1) DEFAULT \'NULL\', CHANGE app_futher_correspondence app_futher_correspondence TINYINT(1) DEFAULT \'NULL\', CHANGE app_complaints app_complaints TINYINT(1) DEFAULT \'NULL\', CHANGE app_financial_loss app_financial_loss TINYINT(1) DEFAULT \'NULL\', CHANGE app_reimbursements app_reimbursements TINYINT(1) DEFAULT \'NULL\', CHANGE app_credit_monitoring app_credit_monitoring TINYINT(1) DEFAULT \'NULL\', CHANGE app_emotional_distress app_emotional_distress TINYINT(1) DEFAULT \'NULL\', CHANGE pro_claim_reference pro_claim_reference INT DEFAULT NULL');
    }
}
