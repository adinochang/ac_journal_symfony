<?php

namespace App\Form;

use App\Entity\AcJournalEntry;

use App\Repository\AcJournalQuestionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcJournalEntryType extends AbstractType
{
    private $questionRepository;

    public function __construct(AcJournalQuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answers', CollectionType::class, [
                'entry_type' => AcJournalAnswerType::class,
                'entry_options' => [],
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
            'data_class' => AcJournalEntry::class,
        ]);
    }
}
