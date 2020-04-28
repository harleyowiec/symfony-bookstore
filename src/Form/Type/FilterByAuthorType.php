<?php

namespace App\Form\Type;

use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterByAuthorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'placeholder' => 'Choose an author',
                'choice_label' => function ($author) {
                    return $author->getName() . ' ' . $author->getSurname();
                }
            ])
            ->add('name', TextType::class)
            ->add('search', SubmitType::class);
    }
}
