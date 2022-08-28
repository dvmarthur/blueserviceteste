<?php


namespace App\Controller;

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






class ProdutoController extends AbstractController


{
    /**
     * @Route("/produto",name="produtoindex")
     */
    public function index(ProdutoRepository $produtoRepository): Response
    {


        $data['produtos'] = $produtoRepository->findAll();
        $data['titulo'] = 'Gerenciar Produto';

        return $this->render('produto/index.html.twig',$data);
    }

    /**
     * @Route("/produto/adicionar",name="produtoadicionar")
     */
    public function adicionar(Request $request,EntityManagerInterface $em): Response
    {
       
        $msg= '';
        $statusmsg= '';
        $produto = new Produto;
        $form = $this->createForm(ProdutoType::class,$produto);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($produto);
            $uploadedFile = $form['imagem']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $produto->getid()."-imagem.jpg";
            $produto->setImagem($produto->getid()."-imagem.jpg");

            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $em->persist($produto);
            $em->flush();
            $msg = "Produto Adicionado com sucesso!";
            $statusmsg= 'success';
             
        }
        return $this->render('produto/form.html.twig', [
            'register_form' => $form->createView(),
            'msg'=> $msg,
            'statusmsg'=>$statusmsg
        ]);
    }


    /**
     * @Route("/produto/editar/{id}",name="produtoeditar")
     */
    public function editar($id,Request $request, EntityManagerInterface $em,ProdutoRepository $produtoRepository): Response
    {
        $msg = '';
        $statusmsg = '';
        $produto = $produtoRepository->find($id);
        $form = $this->createForm(ProdutoType::class,$produto);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $em->persist($produto);
            $uploadedFile = $form['imagem']->getData();
            $produto->setImagem($produto->getid()."-imagem.jpg");
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $produto->getid()."-imagem.jpg";
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $em->persist($produto);
             $em->flush();
            $msg = "produto Atualizado com sucesso!";
            $statusmsg= 'success';
             
        }
        return $this->render('produto/form.html.twig', [
            'register_form' => $form->createView(),
            'msg'=> $msg,
            'statusmsg'=>$statusmsg
        ]);
    }

     /**
     * @Route("/produto/excluir/{id}",name="produtoexcluir")
     */
    public function excluir($id,Request $request, EntityManagerInterface $em,ProdutoRepository $produtoRepository,Filesystem $filesystem): Response
    {


        $msg = '';
        $statusmsg = '';
        $produto = $produtoRepository->find($id);
        $file= $this->getParameter('kernel.project_dir')."/public/uploads/".$produto->getid()."-imagem.jpg";
        unlink($file);
         $em->remove($produto);
         $em->flush();
        
        return $this->redirectToRoute('produtoindex');
    }

     /**
     * @Route("/produto/detalhe/{id}",name="produtodetalhe")
     */
    public function detalhe($id,Request $request, EntityManagerInterface $em,ProdutoRepository $produtoRepository): Response
    {
        $msg = '';
        $statusmsg = '';
        $produto = $produtoRepository->find($id);
       


        return $this->render('produto/detalhe.html.twig', [
            'produto'=>$produto,
            'msg'=> $msg,
            'statusmsg'=>$statusmsg
        ]);
    }
}
