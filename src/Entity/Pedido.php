<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Produto::class, inversedBy: 'pedido')]
    private Collection $produtos;

    #[ORM\Column(length: 255)]
    private ?string $nomecliente = null;

    #[ORM\Column(length: 255)]
    private ?string $endereco = null;

    #[ORM\Column(length: 15)]
    private ?string $telefone = null;

    #[ORM\Column(length: 15)]
    private ?string $cpf = null;

    #[ORM\Column]
    private ?float $totalpedido = null;

    #[ORM\Column(length: 15)]
    private ?string $metodopagamento = null;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Produto>
     */
    public function getProdutos(): Collection
    {
        return $this->produtos;
    }

    public function addProduto(Produto $produto): self
    {
        if (!$this->produtos->contains($produto)) {
            $this->produtos->add($produto);
        }

        return $this;
    }

    public function removeProduto(Produto $produto): self
    {
        $this->produtos->removeElement($produto);

        return $this;
    }

    public function getNomecliente(): ?string
    {
        return $this->nomecliente;
    }

    public function setNomecliente(string $nomecliente): self
    {
        $this->nomecliente = $nomecliente;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getTotalpedido(): ?float
    {
        return $this->totalpedido;
    }

    public function setTotalpedido(float $totalpedido): self
    {
        $this->totalpedido = $totalpedido;

        return $this;
    }

    public function getMetodopagamento(): ?string
    {
        return $this->metodopagamento;
    }

    public function setMetodopagamento(string $metodopagamento): self
    {
        $this->metodopagamento = $metodopagamento;

        return $this;
    }
}
