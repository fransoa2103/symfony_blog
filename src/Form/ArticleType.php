<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    // this below add 2 buttons to validate the form,
    // Symfony recognize that SubmitType is not a field of the entity
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, ['attr'=>['placeholder'=>'ajoutez le titre']])
            ->add('content')
            ->add('createdDate', null, ['widget'=>'single_text'])
            ->add('categories', EntityType::class,
                [
                    'class' => Category::class,
                    'multiple' => true,
                    'by_reference' => false
                ])
            ->add('draft', SubmitType::class, ['label'=>'draft'])
            ->add('publish', SubmitType::class, ['label'=>'To publish'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
