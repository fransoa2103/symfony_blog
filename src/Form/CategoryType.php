<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', null,  ['label' => "Nouvelle catégorie ?", 'attr'=>['placeholder'=>'ajoutez la catégorie ici']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }

    // public function configureOptions(OptionsResolver $resolver): void
    //{
    //    $resolver->setDefaults([
    //        'data_class' => Category::class,
    //    ]);
    // }
}
