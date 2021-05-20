<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Название',
            'required' => true,
            'mapped' => false,
            ],
        )
        ->add('annotation', TextareaType::class, [
            'label' => 'Аннотация',
            'required' => true,
            'mapped' => false,
            ],
        )
        ->add('content', TextareaType::class, [
            'label' => 'Содержание',
            'required' => true,
            'mapped' => false,
            ],
        )
        ->add('save', SubmitType::class, [
            'label' => 'Отправить',
            'attr' => ['class' => 'btn btn-primary w-25 mt-2'],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
