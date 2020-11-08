<?php

namespace App\Form;

use App\Entity\AcJournalQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcJournalQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'attr' => [
                    'class' => '',
                    'required'   => true,
                    'placeholder' => 'What question do you want to ask?'
                ]
            ])
            ->add('sortOrder', NumberType::class, [
                'attr' => [
                    'class' => '',
                    'required'   => true,
                ]
            ])
            ->add('required', ChoiceType::class, [
                'attr' => [
                    'class' => '',
                ],
                'choices' => [
                    'Optional' => 0,
                    'Required' => 1,
                ],
            ])
            ->add('enabled', ChoiceType::class, [
                'attr' => [
                    'class' => '',
                ],
                'choices' => [
                    'Enabled' => 1,
                    'Disabled' => 0,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'special button',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AcJournalQuestion::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'question-new',
        ]);
    }
}
