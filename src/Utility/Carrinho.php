<?php

namespace Utility\Carrinho;


use App\Entity\Activation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class CarrinhoUtility extends ServiceEntityRepository
{

    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, Activation::class);
    }
    
    // public function addProduto($produto,$quantidade)
    // {
    //     die('oi');
    //     $_SESSION['produtos'][]=['nome'=>$produto->getNome(),
    //                             'quantidade'=>$quantidade
    //      ];
    //      die(var_dump($_SESSION));
    //     return true;
    // }

}
