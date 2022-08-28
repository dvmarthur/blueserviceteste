<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Entity\Categoria;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{TextType,ButtonType,EmailType,HiddenType,PasswordType,TextareaType,SubmitType,NumberType,DateType,MoneyType,BirthdayType};
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;


Class PedidoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
       $builder
                ->add('nomecliente',TextType::class,['label'=>'Nome Completo: '])
                ->add('endereco',TextType::class,['label'=>'Endereço:'])
                ->add('telefone',TextType::class,['label'=>'Telefone:' ])
                ->add('cpf',TextType::class,['label'=>'CPF:',
                'attr' => ['data-mask' => '000.000.000-00'] ])
                ->add('RealizarPedido',SubmitType::class);

    }   

}