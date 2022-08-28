<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


Class CategoriaType extends AbstractType {



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        ->add('nome',TextType::class,
        ['label'=>'Descrição da Categoria'])
        ->add('Salvar',SubmitType::class);
    }

}