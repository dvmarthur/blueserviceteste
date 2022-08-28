<?php


namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoriaController extends AbstractController


{
    /**
     * @Route("/categoria",name="categoriaindex")
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {

        $data['categorias'] = $categoriaRepository->findAll();
        $data['titulo'] = 'Gerenciar Categorias';

        return $this->render('categoria/index.html.twig',$data);
    }

    /**
     * @Route("/categoria/adicionar",name="categoriaadicionar")
     */
    public function adicionar(Request $request,EntityManagerInterface $em): Response
    {

        $msg= '';
        $statusmsg= '';
        $categoria = new Categoria;
        $form = $this->createForm(CategoriaType::class,$categoria);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
    
            $em->persist($categoria);
             $em->flush();
            $msg = "Categoria Adicionada com sucesso!";
            $statusmsg= 'success';
             
        }
        return $this->render('categoria/form.html.twig', [
            'register_form' => $form->createView(),
            'msg'=> $msg,
            'statusmsg'=>$statusmsg
        ]);
    }




    /**
     * @Route("/categoria/editar/{id}",name="categoriaeditar")
     */
    public function editar($id,Request $request, EntityManagerInterface $em,CategoriaRepository $categoriaRepository): Response
    {
        $msg = '';
        $statusmsg = '';
        $categoria = $categoriaRepository->find($id);
        $form = $this->createForm(CategoriaType::class,$categoria);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
    
             $em->flush();
            $msg = "Categoria Atualizada com sucesso!";
            $statusmsg= 'success';
             
        }
        return $this->render('categoria/form.html.twig', [
            'register_form' => $form->createView(),
            'msg'=> $msg,
            'statusmsg'=>$statusmsg
        ]);
    }

     /**
     * @Route("/categoria/excluir/{id}",name="categoriaexcluir")
     */
    public function excluir($id,Request $request, EntityManagerInterface $em,CategoriaRepository $categoriaRepository): Response
    {


        $msg = '';
        $statusmsg = '';
        $categoria = $categoriaRepository->find($id);
         $em->remove($categoria);
         $em->flush();
        
        return $this->redirectToRoute('categoriaindex');
    }
}
