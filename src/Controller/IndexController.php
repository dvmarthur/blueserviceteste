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

       
      $produtos = $produto->findAll();

      return $this->render('index/paginaprincipal.html.twig', ['produtos' => $produtos]);
   }
   /**
    * @Route("/index/search",name="indexsearch")
    */
    public function search(ProdutoRepository $produto,EntityManagerInterface $em): Response
    {  
 
      $nome = $_GET['nome'];
      
      // $prod= $em->createQueryBuilder('c')
      // ->andWhere('c.nome LIKE :nome')
      // ->setParameter('nome', $nome)
      // ->getQuery()
      // ->getResult()
      // ;

      // $nome = 'Monitor samsung 144hz';
      // $qb = $produto->createQueryBuilder('c');
      // $qb->where("LOWER(c.nome) LIKE ?", $nome)
      //    ->setParameter('nome', $nome);
      // $prod = $qb->getQuery()->getArrayResult();

      
      $prod[]=$em->getConnection()->executeQuery(
         "select * from produto where nome ILIKE '%{$nome}%'
         ",
     )->fetchAssociative();

         if($prod[0]==false)
         return $this->redirectToRoute('index');

       return $this->render('index/paginaprincipal.html.twig', ['produtos' => $prod]);
    }


   // public function searchAction(Request $request, string $value, Region $region, category $category): Response
   // {
   //    $form = $this->createForm(SearchType::class, null, [
   //       'method' => 'GET'
   //    ]);
   //    $form->handleRequest($request);

   //    if ($form->isSubmitted() && $form->isValid()) {
   //       $value = $form->getData()->getTitle();
   //       $search = $this->getDoctrine()->getRepository(Advertisement::class)->findBySearch($value, $region, $category);

   //       return $this->render('search/result.html.twig', [
   //          'results' => $search
   //       ]);
   //    }
   //    return $this->render('search/search.html.twig', [
   //       'form' => $form->createView()
   //    ]);
   // }

   // public function findBySearch(string $value, Region $region, Category $category)

   // {
   //    return $this->createQueryBuilder('a')
   //       ->where('a.category = :category')
   //       ->andWhere('a.region = :region')
   //       ->andWhere('a.title LIKE :value')
   //       ->orWhere('a.description LIKE :value')
   //       ->setParameters([
   //          'value' => $value,
   //          'region' => $region,
   //          'category' => $category
   //       ])
   //       ->getQuery()
   //       ->getResult();
   // }
}
