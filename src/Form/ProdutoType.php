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
use Symfony\Component\Validator\Constraints\File;


Class ProdutoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $builder
                ->add('nome',TextType::class,['label'=>'Nome do Produto: '])
                ->add('valor',MoneyType::class,['label'=>'Valor:',
                'divisor' => 100, ])
                ->add('descricao',TextType::class,['label'=>'Descrição:'])
                ->add('categoria',EntityType::class, array(
                        'class' => Categoria::class,
                        'choice_label' =>'nome',
                        'label' =>'Categoria: ',
                        'multiple' => true,
                        'expanded' =>true,                     
                        'required' => true
                  ))
                  ->add('imagem', FileType::class,['mapped' => false, 'constraints' => [
                      new File([
                          'maxSize' => '1024k',
                          'mimeTypes' => [
                              'image/jpeg',
                          ],
                          'mimeTypesMessage' => 'Por favor insira uma imagem no formato jpg',
                      ])
                  ]])
                ->add('Salvar',SubmitType::class);

    }

}