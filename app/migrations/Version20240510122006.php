<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510122006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE discount_children_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE discount_early_booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE travel_early_booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE discount_children (id INT NOT NULL, age INT DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, max_discount DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE discount_early_booking (id INT NOT NULL, travel_id INT DEFAULT NULL, month_payment_start INT NOT NULL, month_payment_end INT NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, max_discount DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C2E36EAFECAB15B3 ON discount_early_booking (travel_id)');
        $this->addSql('CREATE TABLE travel_early_booking (id INT NOT NULL, next_year BOOLEAN NOT NULL, day_travel_start INT NOT NULL, month_travel_start INT NOT NULL, day_travel_end INT NOT NULL, month_travel_end INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE discount_early_booking ADD CONSTRAINT FK_C2E36EAFECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel_early_booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE discount_children_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE discount_early_booking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE travel_early_booking_id_seq CASCADE');
        $this->addSql('ALTER TABLE discount_early_booking DROP CONSTRAINT FK_C2E36EAFECAB15B3');
        $this->addSql('DROP TABLE discount_children');
        $this->addSql('DROP TABLE discount_early_booking');
        $this->addSql('DROP TABLE travel_early_booking');
    }
}
