<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Author;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;



#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $nome = null;

    #[ORM\Column]

    #[Assert\NotBlank]
    private ?float $valor = null;

    #[ORM\Column(length: 50, nullable: true)]

    #[Assert\NotBlank]
    private ?string $imagem = null;

    #[ORM\Column(length: 255)]

    #[Assert\NotBlank]
    private ?string $descricao = null;

    #[ORM\ManyToMany(targetEntity: Categoria::class, inversedBy: 'produtos')]
    #[Assert\NotBlank]
    private Collection $categoria;

    #[ORM\ManyToMany(targetEntity: Pedido::class, mappedBy: 'produtos')]
    private Collection $pedido;

    public function __construct()
    {
        $this->categoria = new ArrayCollection();
        $this->pedido = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function setImagem(?string $imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * @return Collection<int, Categoria>
     */
    public function getCategoria(): Collection
    {
        return $this->categoria;
    }

    public function addCategorium(Categoria $categorium): self
    {
        if (!$this->categoria->contains($categorium)) {
            $this->categoria->add($categorium);
        }

        return $this;
    }

    public function removeCategorium(Categoria $categorium): self
    {
        $this->categoria->removeElement($categorium);

        return $this;
    }
    // public function getEntityManager(EntityManagerInterface $em): EntityManager
    // {
    //     return $em->doctrine->getManager();
    // }


    // public function SearchByNome(int $nome,EntityManagerInterface $em): array
    // {
    //     $conn = $em->$this->getEntityManager()->getConnection();

    //     $sql = "
    //         SELECT * FROM produto where nome ILIKE '%:nome%' ORDER BY ID DESC
    //         ";
    //     $stmt = $conn->prepare($sql);
    //     $resultSet = $stmt->executeQuery(['nome' => $nome]);

    //     // returns an array of arrays (i.e. a raw data set)
    //     return $resultSet->fetchAllAssociative();
    // }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedido(): Collection
    {
        return $this->pedido;
    }

    public function addPedido(Pedido $pedido): self
    {
        if (!$this->pedido->contains($pedido)) {
            $this->pedido->add($pedido);
            $pedido->addProduto($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedido->removeElement($pedido)) {
            $pedido->removeProduto($this);
        }

        return $this;
    }
}
