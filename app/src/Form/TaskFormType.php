<?php

namespace App\Form;

use App\Entity\Tasks;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> false,
                'required' => true,
                'attr' => [
                    'class' => 'bg-transparent block mt-10 mx-auto border-b-2 w-full h-10 text-2xl outline-none',
                    'placeholder' => 'React.js'
                ]
            ])
            ->add('difficulty', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'bg-transparent block mt-10 mx-auto border-b-2 w-full text-2xl outline-none',
                    'placeholder' => 'Difficulty (1 for easiest)'
                ],
                'choices' => [
                    'Difficulty (1 for easiest)' => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4
                ]
            ])
            ->add('timeToLearn', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'bg-transparent block mt-10 mx-auto border-b-2 w-full h-10 text-2xl outline-none',
                    'placeholder' => 'Time to learn in hours'
                ]
            ])
            ->add('priority', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'bg-transparent block mt-10 mx-auto border-b-2 w-full text-2xl outline-none',
                    'placeholder' => 'Difficulty (1 for easiest)'
                ],
                'choices' => [
                    'Priority (4 for urgent)' => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4
                ]
            ])
            ->add('notes', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'bg-transparent h-20 block mt-10 mx-auto border-b-2 w-full text-lg outline-none',
                    'placeholder' => 'Learn this to be able to ...'
                ]
            ])
            ->add('state', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'bg-transparent block mt-10 mx-auto border-b-2 w-full text-2xl outline-none',
                    'placeholder' => 'Difficulty (1 for easiest)'
                ],
                'choices' => [
                    'State' => 0,
                    "Not yet started" => 1,
                    'In progress' => 2,
                    'Done' => 3,
                ]
            ])
            // ->add('user_id', HiddenType::class, [
            //     'label' => false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
}
