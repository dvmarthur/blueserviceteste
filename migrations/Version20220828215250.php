<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828215250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT NOT NULL, nome VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pedido (id INT NOT NULL, nomecliente VARCHAR(255) NOT NULL, endereco VARCHAR(255) NOT NULL, telefone VARCHAR(15) NOT NULL, cpf VARCHAR(15) NOT NULL, totalpedido DOUBLE PRECISION NOT NULL, metodopagamento VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pedido_produto (pedido_id INT NOT NULL, produto_id INT NOT NULL, PRIMARY KEY(pedido_id, produto_id))');
        $this->addSql('CREATE INDEX IDX_3ED5C1B94854653A ON pedido_produto (pedido_id)');
        $this->addSql('CREATE INDEX IDX_3ED5C1B9105CFD56 ON pedido_produto (produto_id)');
        $this->addSql('CREATE TABLE produto (id INT NOT NULL, nome VARCHAR(50) NOT NULL, valor DOUBLE PRECISION NOT NULL, imagem VARCHAR(50) DEFAULT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produto_categoria (produto_id INT NOT NULL, categoria_id INT NOT NULL, PRIMARY KEY(produto_id, categoria_id))');
        $this->addSql('CREATE INDEX IDX_D5E7E35C105CFD56 ON produto_categoria (produto_id)');
        $this->addSql('CREATE INDEX IDX_D5E7E35C3397707A ON produto_categoria (categoria_id)');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B94854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B9105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto_categoria ADD CONSTRAINT FK_D5E7E35C105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto_categoria ADD CONSTRAINT FK_D5E7E35C3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pedido_produto DROP CONSTRAINT FK_3ED5C1B94854653A');
        $this->addSql('ALTER TABLE pedido_produto DROP CONSTRAINT FK_3ED5C1B9105CFD56');
        $this->addSql('ALTER TABLE produto_categoria DROP CONSTRAINT FK_D5E7E35C105CFD56');
        $this->addSql('ALTER TABLE produto_categoria DROP CONSTRAINT FK_D5E7E35C3397707A');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE pedido_produto');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE produto_categoria');
    }
}
