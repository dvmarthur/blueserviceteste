<?php


namespace App\Controller;

use App\Entity\Pedido;
use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use App\Repository\PedidoRepository;
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






class PedidoController extends AbstractController


{
    /**
     * @Route("/pedidos",name="pedidosindex")
     */
    public function index(PedidoRepository $pedidoRepository): Response
    {
        $data['pedidos'] = $pedidoRepository->findAll();
        $data['titulo'] = 'Gerenciar Produto';

        return $this->render('pedido/index.html.twig',$data);
    }

    /**
     * @Route("/pedidos/detalhe/{pedidoid}",name="pedidosdetalhe")
     */
    public function detalhe($pedidoid,PedidoRepository $pedidoRepository): Response
    {
        $msg = '';
        $statusmsg = '';
        $pedido = $pedidoRepository->find($pedidoid);

        return $this->render('pedido/detalhe.html.twig', [
            'pedido'=>$pedido,
            'msg'=> $msg,
            'statusmsg'=>$statusmsg
        ]);
    }

     /**
     * @Route("/pedido/excluir/{id}",name="pedidoexcluir")
     */
    public function excluir($id,Request $request, EntityManagerInterface $em,PedidoRepository $pedidoRepository): Response
    {


        $msg = '';
        $statusmsg = '';
        $pedido = $pedidoRepository->find($id);
             
         $em->remove($pedido);
         $em->flush();
        
        return $this->redirectToRoute('pedidosindex');
    }
}
