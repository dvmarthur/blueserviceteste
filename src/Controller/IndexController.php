<?php


namespace App\Controller;

use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController

{
/**
 * @Route("/",name="index")
 */
    public function index(ProdutoRepository $produto) : Response
    {
        $produtos= $produto->findAll();

     return $this->render('index/paginaprincipal.html.twig',['produtos'=>$produtos]);
     }


}