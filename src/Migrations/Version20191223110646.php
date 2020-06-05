<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191223110646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bacorrespondence CHANGE received_confirmation_email received_confirmation_email VARCHAR(255) DEFAULT NULL, CHANGE breach_one_date breach_one_date VARCHAR(255) DEFAULT NULL, CHANGE breach_one_notification breach_one_notification VARCHAR(255) DEFAULT NULL, CHANGE breach_one_date_received breach_one_date_received DATE DEFAULT NULL, CHANGE breach_one_notification_file_path breach_one_notification_file_path VARCHAR(255) DEFAULT NULL, CHANGE breach_one_notification_not_affected breach_one_notification_not_affected VARCHAR(255) DEFAULT NULL, CHANGE breach_one_date_of_booking breach_one_date_of_booking DATE DEFAULT NULL, CHANGE breach_one_email_address_used breach_one_email_address_used VARCHAR(255) DEFAULT NULL, CHANGE breach_one_booking_reference breach_one_booking_reference VARCHAR(255) DEFAULT NULL, CHANGE breach_one_booking_platform breach_one_booking_platform VARCHAR(255) DEFAULT NULL, CHANGE breach_one_payment_method breach_one_payment_method VARCHAR(255) DEFAULT NULL, CHANGE breach_one_booking_confirmation_file_path breach_one_booking_confirmation_file_path VARCHAR(255) DEFAULT NULL, CHANGE breach_two_notification breach_two_notification VARCHAR(255) DEFAULT NULL, CHANGE breach_two_date_received breach_two_date_received DATE DEFAULT NULL, CHANGE breach_two_notification_file_path breach_two_notification_file_path VARCHAR(255) DEFAULT NULL, CHANGE breach_two_notification_not_affected breach_two_notification_not_affected VARCHAR(255) DEFAULT NULL, CHANGE breach_two_date_of_booking breach_two_date_of_booking DATE DEFAULT NULL, CHANGE breach_two_email_address_used breach_two_email_address_used VARCHAR(255) DEFAULT NULL, CHANGE breach_two_booking_reference breach_two_booking_reference VARCHAR(255) DEFAULT NULL, CHANGE breach_two_booking_platform breach_two_booking_platform VARCHAR(255) DEFAULT NULL, CHANGE breach_two_payment_method breach_two_payment_method VARCHAR(255) DEFAULT NULL, CHANGE breach_two_booking_confirmation_file_path breach_two_booking_confirmation_file_path VARCHAR(255) DEFAULT NULL, CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE complaints CHANGE lodged_complaint lodged_complaint VARCHAR(255) DEFAULT NULL, CHANGE complaint_made complaint_made DATE DEFAULT NULL, CHANGE received_response received_response VARCHAR(255) DEFAULT NULL, CHANGE satisfied_response satisfied_response VARCHAR(255) DEFAULT NULL, CHANGE contacted_ioc contacted_ioc VARCHAR(255) DEFAULT NULL, CHANGE contacted_action_fraud contacted_action_fraud VARCHAR(255) DEFAULT NULL, CHANGE accessed_get_safe_online accessed_get_safe_online VARCHAR(255) DEFAULT NULL, CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT NULL, CHANGE street_address street_address VARCHAR(255) DEFAULT NULL, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT NULL, CHANGE town_city town_city VARCHAR(255) DEFAULT NULL, CHANGE county county VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE email_address email_address VARCHAR(255) DEFAULT NULL, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE credit_monitor CHANGE monitor_credit monitor_credit VARCHAR(255) DEFAULT NULL, CHANGE monitor_credit_file_path monitor_credit_file_path VARCHAR(255) DEFAULT NULL, CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE emotional_distress ADD emotions_experienced_new LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE personal_details personal_details VARCHAR(255) DEFAULT NULL, CHANGE emotions_experienced emotions_experienced VARCHAR(255) DEFAULT NULL, CHANGE emotional_distress_lasted emotional_distress_lasted VARCHAR(255) DEFAULT NULL, CHANGE breach_question_a breach_question_a LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_b breach_question_b LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_c breach_question_c LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_d breach_question_d LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_e breach_question_e LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_f breach_question_f LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_g breach_question_g LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE diagnosed_conditions diagnosed_conditions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE impact_condition impact_condition LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE steps_taken steps_taken LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE steps_taken_files_path steps_taken_files_path LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE adverse_consequences adverse_consequences LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE adverse_consequences_files_path adverse_consequences_files_path LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE lead_test_claimant lead_test_claimant VARCHAR(255) DEFAULT NULL, CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE file_reference CHANGE filename filename VARCHAR(255) DEFAULT NULL, CHANGE mime_type mime_type VARCHAR(255) DEFAULT NULL, CHANGE original_file_name original_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE financial_loss CHANGE type_financial_loss type_financial_loss LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE total_loss_amount total_loss_amount DOUBLE PRECISION DEFAULT NULL, CHANGE financial_loss_files_path financial_loss_files_path LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE further_correspondence CHANGE personal_information_breached_file_path personal_information_breached_file_path VARCHAR(255) DEFAULT NULL, CHANGE received_any_other_bacorrespondence received_any_other_bacorrespondence VARCHAR(255) DEFAULT NULL, CHANGE all_correspondence_sent_received_file_path all_correspondence_sent_received_file_path LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL, CHANGE surname surname VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reimbursements CHANGE financial_loss_suffered financial_loss_suffered VARCHAR(255) DEFAULT NULL, CHANGE provider provider VARCHAR(255) DEFAULT NULL, CHANGE amount_reimbursed amount_reimbursed DOUBLE PRECISION DEFAULT NULL, CHANGE reimbursement_files_path reimbursement_files_path LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE complete complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE pro_claim_reference pro_claim_reference INT DEFAULT NULL, CHANGE app_started app_started TINYINT(1) DEFAULT NULL, CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT NULL, CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT NULL, CHANGE app_bacorrespondence app_bacorrespondence TINYINT(1) DEFAULT NULL, CHANGE app_futher_correspondence app_futher_correspondence TINYINT(1) DEFAULT NULL, CHANGE app_complaints app_complaints TINYINT(1) DEFAULT NULL, CHANGE app_financial_loss app_financial_loss TINYINT(1) DEFAULT NULL, CHANGE app_reimbursements app_reimbursements TINYINT(1) DEFAULT NULL, CHANGE app_credit_monitoring app_credit_monitoring TINYINT(1) DEFAULT NULL, CHANGE app_emotional_distress app_emotional_distress TINYINT(1) DEFAULT NULL, CHANGE app_completed app_completed TINYINT(1) DEFAULT NULL, CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bacorrespondence CHANGE received_confirmation_email received_confirmation_email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_date breach_one_date VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_notification breach_one_notification VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_date_received breach_one_date_received DATE DEFAULT \'NULL\', CHANGE breach_one_notification_file_path breach_one_notification_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_notification_not_affected breach_one_notification_not_affected VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_date_of_booking breach_one_date_of_booking DATE DEFAULT \'NULL\', CHANGE breach_one_email_address_used breach_one_email_address_used VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_booking_reference breach_one_booking_reference VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_booking_platform breach_one_booking_platform VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_payment_method breach_one_payment_method VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_one_booking_confirmation_file_path breach_one_booking_confirmation_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE complete complete TINYINT(1) DEFAULT \'NULL\', CHANGE breach_two_notification breach_two_notification VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_date_received breach_two_date_received DATE DEFAULT \'NULL\', CHANGE breach_two_notification_file_path breach_two_notification_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_notification_not_affected breach_two_notification_not_affected VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_date_of_booking breach_two_date_of_booking DATE DEFAULT \'NULL\', CHANGE breach_two_email_address_used breach_two_email_address_used VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_booking_reference breach_two_booking_reference VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_booking_platform breach_two_booking_platform VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_payment_method breach_two_payment_method VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_two_booking_confirmation_file_path breach_two_booking_confirmation_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE complaints CHANGE lodged_complaint lodged_complaint VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE complaint_made complaint_made DATE DEFAULT \'NULL\', CHANGE received_response received_response VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE satisfied_response satisfied_response VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE contacted_ioc contacted_ioc VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE contacted_action_fraud contacted_action_fraud VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE accessed_get_safe_online accessed_get_safe_online VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE complete complete TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address street_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE town_city town_city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE county county VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE postcode postcode VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email_address email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE credit_monitor CHANGE monitor_credit monitor_credit VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE monitor_credit_file_path monitor_credit_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE complete complete TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE emotional_distress DROP emotions_experienced_new, CHANGE personal_details personal_details VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE emotions_experienced emotions_experienced VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE emotional_distress_lasted emotional_distress_lasted VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breach_question_a breach_question_a LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_b breach_question_b LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_c breach_question_c LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_d breach_question_d LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_e breach_question_e LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_f breach_question_f LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE breach_question_g breach_question_g LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE diagnosed_conditions diagnosed_conditions LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE impact_condition impact_condition LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE steps_taken steps_taken LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE steps_taken_files_path steps_taken_files_path LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE adverse_consequences adverse_consequences LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE adverse_consequences_files_path adverse_consequences_files_path LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE lead_test_claimant lead_test_claimant VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE complete complete TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE file_reference CHANGE filename filename VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mime_type mime_type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE original_file_name original_file_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE financial_loss CHANGE type_financial_loss type_financial_loss LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE total_loss_amount total_loss_amount DOUBLE PRECISION DEFAULT \'NULL\', CHANGE financial_loss_files_path financial_loss_files_path LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE complete complete TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE further_correspondence CHANGE personal_information_breached_file_path personal_information_breached_file_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE received_any_other_bacorrespondence received_any_other_bacorrespondence VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE all_correspondence_sent_received_file_path all_correspondence_sent_received_file_path LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE complete complete TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE middle_name middle_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE surname surname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE completed completed TINYINT(1) DEFAULT \'NULL\', CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE reimbursements CHANGE financial_loss_suffered financial_loss_suffered VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE provider provider VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE amount_reimbursed amount_reimbursed DOUBLE PRECISION DEFAULT \'NULL\', CHANGE reimbursement_files_path reimbursement_files_path LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE complete complete TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE app_started app_started TINYINT(1) DEFAULT \'NULL\', CHANGE app_completed app_completed TINYINT(1) DEFAULT \'NULL\', CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE app_bacorrespondence app_bacorrespondence TINYINT(1) DEFAULT \'NULL\', CHANGE app_futher_correspondence app_futher_correspondence TINYINT(1) DEFAULT \'NULL\', CHANGE app_complaints app_complaints TINYINT(1) DEFAULT \'NULL\', CHANGE app_financial_loss app_financial_loss TINYINT(1) DEFAULT \'NULL\', CHANGE app_reimbursements app_reimbursements TINYINT(1) DEFAULT \'NULL\', CHANGE app_credit_monitoring app_credit_monitoring TINYINT(1) DEFAULT \'NULL\', CHANGE app_emotional_distress app_emotional_distress TINYINT(1) DEFAULT \'NULL\', CHANGE pro_claim_reference pro_claim_reference INT DEFAULT NULL');
    }
}
