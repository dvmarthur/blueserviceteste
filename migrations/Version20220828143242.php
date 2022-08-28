<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828143242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pedido_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pedido (id INT NOT NULL, nomecliente VARCHAR(255) NOT NULL, endereco VARCHAR(255) NOT NULL, telefone VARCHAR(15) NOT NULL, cpf VARCHAR(15) NOT NULL, totalpedido DOUBLE PRECISION NOT NULL, metodopagamento VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pedido_produto (pedido_id INT NOT NULL, produto_id INT NOT NULL, PRIMARY KEY(pedido_id, produto_id))');
        $this->addSql('CREATE INDEX IDX_3ED5C1B94854653A ON pedido_produto (pedido_id)');
        $this->addSql('CREATE INDEX IDX_3ED5C1B9105CFD56 ON pedido_produto (produto_id)');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B94854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B9105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pedido_id_seq CASCADE');
        $this->addSql('ALTER TABLE pedido_produto DROP CONSTRAINT FK_3ED5C1B94854653A');
        $this->addSql('ALTER TABLE pedido_produto DROP CONSTRAINT FK_3ED5C1B9105CFD56');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE pedido_produto');
    }
}
