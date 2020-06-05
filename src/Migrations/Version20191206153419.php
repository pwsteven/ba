<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191206153419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bacorrespondence ADD complete TINYINT(1) DEFAULT NULL, CHANGE received_confirmation_email received_confirmation_email VARCHAR(255) DEFAULT NULL, CHANGE breach_one_date breach_one_date VARCHAR(255) DEFAULT NULL, CHANGE breach_one_notification breach_one_notification VARCHAR(255) DEFAULT NULL, CHANGE breach_one_date_received breach_one_date_received DATE DEFAULT NULL, CHANGE breach_one_notification_file_path breach_one_notification_file_path VARCHAR(255) DEFAULT NULL, CHANGE breach_one_notification_not_affected breach_one_notification_not_affected VARCHAR(255) DEFAULT NULL, CHANGE breach_one_date_of_booking breach_one_date_of_booking DATE DEFAULT NULL, CHANGE breach_one_email_address_used breach_one_email_address_used VARCHAR(255) DEFAULT NULL, CHANGE breach_one_booking_reference breach_one_booking_reference VARCHAR(255) DEFAULT NULL, CHANGE breach_one_booking_platform breach_one_booking_platform VARCHAR(255) DEFAULT NULL, CHANGE breach_one_payment_method breach_one_payment_method VARCHAR(255) DEFAULT NULL, CHANGE breach_one_booking_confirmation_file_path breach_one_booking_confirmation_file_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT NULL, CHANGE street_address street_address VARCHAR(255) DEFAULT NULL, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT NULL, CHANGE town_city town_city VARCHAR(255) DEFAULT NULL, CHANGE county county VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE email_address email_address VARCHAR(255) DEFAULT NULL, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE file_reference CHANGE filename filename VARCHAR(255) DEFAULT NULL, CHANGE mime_type mime_type VARCHAR(255) DEFAULT NULL, CHANGE original_file_name original_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL, CHANGE surname surname VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE pro_claim_reference pro_claim_reference INT DEFAULT NULL, CHANGE app_started app_started TINYINT(1) DEFAULT NULL, CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT NULL, CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT NULL, CHANGE app_bacorrespondence app_bacorrespondence TINYINT(1) DEFAULT NULL, CHANGE app_futher_correspondence app_futher_correspondence TINYINT(1) DEFAULT NULL, CHANGE app_complaints app_complaints TINYINT(1) DEFAULT NULL, CHANGE app_financial_loss app_financial_loss TINYINT(1) DEFAULT NULL, CHANGE app_reimbursements app_reimbursements TINYINT(1) DEFAULT NULL, CHANGE app_credit_monitoring app_credit_monitoring TINYINT(1) DEFAULT NULL, CHANGE app_emotional_distress app_emotional_distress TINYINT(1) DEFAULT NULL, CHANGE app_completed app_completed TINYINT(1) DEFAULT NULL, CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bacorrespondence DROP complete, CHANGE received_confirmation_email received_confirmation_email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_date breach_one_date VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_notification breach_one_notification VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_date_received breach_one_date_received DATE DEFAULT \'NULL\', CHANGE breach_one_notification_file_path breach_one_notification_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_notification_not_affected breach_one_notification_not_affected VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_date_of_booking breach_one_date_of_booking DATE DEFAULT \'NULL\', CHANGE breach_one_email_address_used breach_one_email_address_used VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_booking_reference breach_one_booking_reference VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_booking_platform breach_one_booking_platform VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_payment_method breach_one_payment_method VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_booking_confirmation_file_path breach_one_booking_confirmation_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address street_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE town_city town_city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE county county VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE postcode postcode VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email_address email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE file_reference CHANGE filename filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mime_type mime_type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE original_file_name original_file_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE middle_name middle_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE surname surname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE completed completed TINYINT(1) DEFAULT \'NULL\', CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE app_started app_started TINYINT(1) DEFAULT \'NULL\', CHANGE app_completed app_completed TINYINT(1) DEFAULT \'NULL\', CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE app_bacorrespondence app_bacorrespondence TINYINT(1) DEFAULT \'NULL\', CHANGE app_futher_correspondence app_futher_correspondence TINYINT(1) DEFAULT \'NULL\', CHANGE app_complaints app_complaints TINYINT(1) DEFAULT \'NULL\', CHANGE app_financial_loss app_financial_loss TINYINT(1) DEFAULT \'NULL\', CHANGE app_reimbursements app_reimbursements TINYINT(1) DEFAULT \'NULL\', CHANGE app_credit_monitoring app_credit_monitoring TINYINT(1) DEFAULT \'NULL\', CHANGE app_emotional_distress app_emotional_distress TINYINT(1) DEFAULT \'NULL\', CHANGE pro_claim_reference pro_claim_reference INT DEFAULT NULL');
    }
}
