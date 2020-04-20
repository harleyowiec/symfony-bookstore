<?php
namespace App\Form\Type;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('number_of_pages', IntegerType::class)
            ->add('year', IntegerType::class)
            ->add('authors', ChoiceType::class, [
                'choices' => $options['data'],
                'choice_value' => 'id',
                'choice_label' => function(?Author $author) {
                    return $author ? $author->getName() . ' ' . $author->getSurname() : '';
                },
            ])
            ->add('save', SubmitType::class);
    }
}
