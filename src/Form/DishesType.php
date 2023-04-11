<?php

namespace App\Form;
use App\Entity\Dishes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;


class DishesType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
        ->add('name', TextType::class, ['attr' => ['class' => 'form-control m-2', 'placeholder' => 'Type the name of the dish']])
        ->add('price', TextType::class, ['attr' => ['class' => 'form-control m-2', 'placeholder' => 'Type the price of the dish']])
        ->add('description', TextareaType::class, ['attr' => ['class' => 'form-control m-2', 'placeholder' => 'Description']])
        // ->add('attachment', FileType::class, ['attr' => ['class' => 'form-control m-2', ]])
        ->add('save', SubmitType::class, ['label' => 'Add dish', 'attr' => ['class' => 'btn-success m-2', ]]);
    }
}