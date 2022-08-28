<?php

namespace App\Controller;

session_start();
use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class CarrinhoController extends AbstractController

{

    

    /**
     * @Route("/carrinho",name="carrinhoindex")
     */
    public function index(): Response
    {
    
        $prodscarrinho = '';
       
       if(isset($_SESSION['produtos'])){
       $prodscarrinho = $_SESSION['produtos'];
       }
        
        return $this->render('carrinho/index.html.twig',['prodscarrinho'=>$prodscarrinho]);
    }

    /**
     * @Route("/carrinho/adicionar/{prodid}",name="carrinhoadicionar")
     */
    public function adicionar($prodid,ProdutoRepository $produtoRepository)
    {   
        
        $produto = $produtoRepository->find($prodid);
        $compras = $this->addProduto($produto,'12');

        return $this->redirectToRoute('carrinhoindex');
    }


    public function addProduto($produto,$quantidade)
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['produtos'])){
          if(array_key_exists($produto->getId(),$_SESSION['produtos'])){
            $_SESSION['produtos'][$produto->getId()]['quantidade'] += $quantidade;       
            return true;
          }
        }


        $_SESSION['produtos'][$produto->getId()]=['id' =>$produto->getId(),
                                                 'nome'=>$produto->getNome(),
                                                 'quantidade'=>$quantidade
         ];
       
        return true;
    }


    public function removeProduto($produto,$quantidade)
    {
        
        if (session_status() === PHP_SESSION_NONE) {
           return "Sem produtos no carrinho";
        }
        if(array_key_exists($produto->getId(),$_SESSION['produtos'])){
            unset($_SESSION['produtos'][$produto->getId()]);
          }
       
        return true;
    }

     /**
     * @Route("/carrinho/limparcarrinho",name="limparcarrinho")
     */
    public function limparcarrinho()
    {
        
        if (session_status() === PHP_SESSION_NONE) {
           return "Carrinho vazio";
        }
        session_destroy();

        return $this->redirectToRoute('carrinhoindex');
    }


   
}
