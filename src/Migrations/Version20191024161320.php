<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024161320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT NULL, CHANGE street_address street_address VARCHAR(255) DEFAULT NULL, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT NULL, CHANGE town_city town_city VARCHAR(255) DEFAULT NULL, CHANGE county county VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE email_address email_address VARCHAR(255) DEFAULT NULL, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL, CHANGE surname surname VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE photo_id photo_id VARCHAR(255) DEFAULT NULL, CHANGE completed completed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD app_bacorrespondence TINYINT(1) DEFAULT NULL, ADD app_futher_correspondence TINYINT(1) DEFAULT NULL, ADD app_complaints TINYINT(1) DEFAULT NULL, ADD app_financial_loss TINYINT(1) DEFAULT NULL, ADD app_reimbursements TINYINT(1) DEFAULT NULL, ADD app_credit_monitoring TINYINT(1) DEFAULT NULL, ADD app_emotional_distress TINYINT(1) DEFAULT NULL, CHANGE app_started app_started TINYINT(1) DEFAULT NULL, CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT NULL, CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT NULL, CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT NULL, CHANGE app_completed app_completed TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_details CHANGE house_name_number house_name_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address street_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE street_address2 street_address2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE town_city town_city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE county county VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE postcode postcode VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email_address email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile_telephone_number mobile_telephone_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE personal_details CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE middle_name middle_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE surname surname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE photo_id photo_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE completed completed TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user DROP app_bacorrespondence, DROP app_futher_correspondence, DROP app_complaints, DROP app_financial_loss, DROP app_reimbursements, DROP app_credit_monitoring, DROP app_emotional_distress, CHANGE app_started app_started TINYINT(1) DEFAULT \'NULL\', CHANGE app_completed app_completed TINYINT(1) DEFAULT \'NULL\', CHANGE app_personal_details app_personal_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_contact_details app_contact_details TINYINT(1) DEFAULT \'NULL\', CHANGE app_current_form app_current_form VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
