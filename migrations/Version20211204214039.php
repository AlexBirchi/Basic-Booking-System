<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211204214039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facility (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_room_facility TINYINT(1) DEFAULT NULL, is_property_facility TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, street VARCHAR(255) NOT NULL, property_number VARCHAR(255) NOT NULL, INDEX IDX_5E9E89CB8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, property_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, likes INT NOT NULL, UNIQUE INDEX UNIQ_8BF21CDE64D218E (location_id), INDEX IDX_8BF21CDE9C81C6EB (property_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_facility (property_id INT NOT NULL, facility_id INT NOT NULL, INDEX IDX_4EDEA0F6549213EC (property_id), INDEX IDX_4EDEA0F6A7014910 (facility_id), PRIMARY KEY(property_id, facility_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, has_multiple_rooms TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, user_id INT NOT NULL, check_in DATETIME NOT NULL, check_out DATETIME NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_42C84955549213EC (property_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, room_type_id INT DEFAULT NULL, adults_capacity SMALLINT NOT NULL, children_capacity SMALLINT DEFAULT NULL, base_price INT NOT NULL, INDEX IDX_729F519B549213EC (property_id), INDEX IDX_729F519B296E3073 (room_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_facility (room_id INT NOT NULL, facility_id INT NOT NULL, INDEX IDX_B0BF547654177093 (room_id), INDEX IDX_B0BF5476A7014910 (facility_id), PRIMARY KEY(room_id, facility_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_beds (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, bed VARCHAR(255) NOT NULL, INDEX IDX_55EE8D1E54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE property_facility ADD CONSTRAINT FK_4EDEA0F6549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_facility ADD CONSTRAINT FK_4EDEA0F6A7014910 FOREIGN KEY (facility_id) REFERENCES facility (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B296E3073 FOREIGN KEY (room_type_id) REFERENCES room_type (id)');
        $this->addSql('ALTER TABLE room_facility ADD CONSTRAINT FK_B0BF547654177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_facility ADD CONSTRAINT FK_B0BF5476A7014910 FOREIGN KEY (facility_id) REFERENCES facility (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_beds ADD CONSTRAINT FK_55EE8D1E54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB8BAC62AF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE property_facility DROP FOREIGN KEY FK_4EDEA0F6A7014910');
        $this->addSql('ALTER TABLE room_facility DROP FOREIGN KEY FK_B0BF5476A7014910');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE64D218E');
        $this->addSql('ALTER TABLE property_facility DROP FOREIGN KEY FK_4EDEA0F6549213EC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955549213EC');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B549213EC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9C81C6EB');
        $this->addSql('ALTER TABLE room_facility DROP FOREIGN KEY FK_B0BF547654177093');
        $this->addSql('ALTER TABLE room_beds DROP FOREIGN KEY FK_55EE8D1E54177093');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B296E3073');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE facility');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_facility');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_facility');
        $this->addSql('DROP TABLE room_beds');
        $this->addSql('DROP TABLE room_type');
    }
}
