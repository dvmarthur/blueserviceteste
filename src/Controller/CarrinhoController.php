<?php

namespace App\Controller;

session_start();

use App\Entity\Pedido;
use App\Entity\Produto;
use App\Form\PedidoType;
use App\Repository\PedidoRepository;
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
    public function index(Request $request,ProdutoRepository $produtoRepository,EntityManagerInterface $em): Response
    {

        $msg = "";
        $statusmsg= '';
        $prodscarrinho = '';
        $pedido = new Pedido;
       if(isset($_SESSION['produtos'])){
       $prodscarrinho = $_SESSION['produtos'];
       }
       $form = $this->createForm(PedidoType::class,$pedido);
       $form->handleRequest($request);

       if(!isset($_SESSION['produtos'])){
        $msg = "Sem produtos no carrinho para realizar pedido";
        $statusmsg= 'warning';
        return $this->render('carrinho/index.html.twig',['prodscarrinho'=>$prodscarrinho,'msg'=>$msg,'statusmsg'=>$statusmsg,'form'=>$form->createView()]);
      }
       if($form->isSubmitted() && $form->isValid()){

            foreach($_SESSION['produtos'] as $k => $v){
                $produto = $produtoRepository->find($k);
                $pedido->addProduto($produto);
            }

          
            $em->persist($pedido);
            $em->flush();
           $msg = "Pedido Realizado com Sucesso!";
           $statusmsg= 'success';
            
       }

        return $this->render('carrinho/index.html.twig',['prodscarrinho'=>$prodscarrinho,'msg'=>$msg,'statusmsg'=>$statusmsg,'form'=>$form->createView()]);
    }

    /**
     * @Route("/carrinho/adicionar/{prodid}",name="carrinhoadicionar")
     */
    public function adicionar($prodid,ProdutoRepository $produtoRepository)
    {   
        
        $produto = $produtoRepository->find($prodid);
        $compras = $this->addProduto($produto,'1');

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


    /**
     * @Route("/carrinho/remove/{prodid}",name="carrinhoremove")
     */
    public function remove($prodid)
    {
       
        if (session_status() === PHP_SESSION_NONE) {
           return "Sem produtos no carrinho";
           return $this->redirectToRoute('carrinhoindex');
        }
        if(array_key_exists($prodid,$_SESSION['produtos'])){
            unset($_SESSION['produtos'][$prodid]);
          }
       
          return $this->redirectToRoute('carrinhoindex');
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
