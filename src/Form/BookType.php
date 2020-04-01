<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de Livre'
            ])
            ->add('resume')
            ->add('nbPages')

            // on créé un champs author, qui permettra de choisi un auteru pour un livre
            // contrairement au autres champs, author est une relation vers une autre entité
            // donc il faut utiliser en type de champs "EntityType"
            ->add('author', EntityType::class, [
            // je choisis ici vers quelle entité on relie notre champs
                'class' => Author::class,
            // Je choisis ici la propriété de l'entité Author dans l'input
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
