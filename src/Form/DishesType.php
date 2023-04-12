<?php

namespace App\Form;
use App\Entity\Dishes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class DishesType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
        ->add('name', TextType::class, ['attr' => ['class' => 'form-control m-2', 'placeholder' => 'Type the name of the dish']])
        ->add('price', TextType::class, ['attr' => ['class' => 'form-control m-2', 'placeholder' => 'Type the price of the dish']])
        ->add('description', TextareaType::class, ['attr' => ['class' => 'form-control m-2', 'placeholder' => 'Description']])
        // ->add('attachment', FileType::class, ['attr' => ['class' => 'form-control m-2', ]])
        ->add('fk_status', EntityType::class, [
            'class' => Status::class,

            'choice_label' => 'name',
            'attr' => ['class' => 'form-control m-2', ],
        
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
        ])
        ->add('picture', FileType::class, [
            'label' => 'Picture (image file)',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                        'image/jpg'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image file',
                ])
            ], 'attr' => ['class' => 'form-control m-2', ],
        ])
        ->add('save', SubmitType::class, ['label' => 'Save', 'attr' => ['class' => 'btn btn-success m-2', ]]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dishes::class,
        ]);
    }
}