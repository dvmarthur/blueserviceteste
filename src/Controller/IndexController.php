<?php


namespace App\Controller;

use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class IndexController extends AbstractController

{
   /**
    * @Route("/",name="index")
    */
   public function index(ProdutoRepository $produto): Response
   {   

      $msg ='';
       
      $produtos = $produto->findAll();

      return $this->render('index/paginaprincipal.html.twig', ['produtos' => $produtos,'msg'=>$msg]);
   }
   /**
    * @Route("/index/search",name="indexsearch")
    */
    public function search(ProdutoRepository $produto,EntityManagerInterface $em): Response
    {  
 
      $nome = $_GET['nome'];
      $msg = '';
      $prod[]=$em->getConnection()->executeQuery(
         "select * from produto where nome ILIKE '%{$nome}%'
         ",
     )->fetchAssociative();

         if($prod[0]==false || empty($nome)){
            $msg = "Sem resultados,Exibindo todos!";
            $prod = $produto->findAll();
            return $this->render('index/paginaprincipal.html.twig', ['produtos' => $prod,'msg'=>$msg]);
         }

        
       return $this->render('index/paginaprincipal.html.twig', ['produtos' => $prod,'msg'=>$msg]);
    }


  
}
