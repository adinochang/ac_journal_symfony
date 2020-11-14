<?php

namespace App\Form;

use App\Entity\AcJournalAnswer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcJournalAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add answerText depending on question setup
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $question = $form->getViewData()->getQuestion();

            if (isset($question)) {
                $form->add('answerText', TextareaType::class, [
                    'label' => $question->getLabel(),
                    'required' => $question->getRequired(),
                    'attr' => [
                        'class' => 'entry-form-textarea',
                        'placeholder' => 'Enter your answer',
                    ],]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AcJournalAnswer::class,
        ]);
    }
}
