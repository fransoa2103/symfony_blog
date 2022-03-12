<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // for each new comment, date is create with /src/Entity/Comment/__construct()
        $builder
            ->add('contenu',null, ['label' => "votre commentaire"])
            ->add('author', null, ['label' => "Votre nom"])
            // ajout d'un champ hors contexte à la table 'comment'. ex: une checkbox pour confirmer les "conditions"
            // for this example, i add checkbox to the form, checkbox has not to do with entity, so "mapped" = fault
            ->add('conditions', CheckboxType::class, ['mapped' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
