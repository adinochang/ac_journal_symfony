<?php

namespace App\Controller;

use App\Entity\AcJournalEntry;
use App\Entity\AcJournalAnswer;
use App\Form\AcJournalEntryType;
use App\Repository\AcJournalEntryRepository;
use App\Repository\AcJournalQuestionRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class EntryController extends AbstractController
{
    private $entryRepository;
    private $questionRepository;

    public function __construct(AcJournalEntryRepository $entryRepository,
        AcJournalQuestionRepository $questionRepository)
    {
        $this->entryRepository = $entryRepository;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @Route("/entry", name="entry_index")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $entriesQueryBuilder = $this->entryRepository->getWithSearchQueryBuilder($request->query->get('filter_date'));

        $pagination = $paginator->paginate(
            $entriesQueryBuilder, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->render('entry/index.html.twig', [
            'pagination' => $pagination,
            'filter_date' => $request->query->get('filter_date'),
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Environment $twigEnvironment) {
        return new Response(
            $twigEnvironment->render('home.html.twig')
        );
    }

    /**
     * @Route("/entry/new", name="entry_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entry = new AcJournalEntry();

        $questions = $this->questionRepository->findByEnabled(1);

        foreach($questions as $question)
        {
            $answer = new AcJournalAnswer();
            $answer->setQuestion($question);
            $entry->getAnswers()->add($answer);
        }

        $form = $this->createForm(AcJournalEntryType::class, $entry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entry = $form->getData();

            // save entry
            $save_entry = new AcJournalEntry();
            $save_entry->setAuthor($this->getUser());
            $save_entry->setCreatedAt(new \DateTime());

            $entityManager->persist($save_entry);

            // save answers
            foreach($entry->getAnswers() as $answer)
            {
                if (isset($answer) && strlen(trim($answer->getAnswerText())) > 0)
                {
                    $save_answer = new AcJournalAnswer();

                    $save_answer->setAnswerText($answer->getAnswerText());
                    $save_answer->setEntry($save_entry);
                    $save_answer->setQuestion($answer->getQuestion());
                    $save_answer->setCreatedAt(new \DateTime());

                    $entityManager->persist($save_answer);
                }
            }

            // save to database
            $entityManager->flush();

            $this->addFlash('success', 'Save successful');

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('entry/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/entry/{id}", name="entry_edit", requirements={"id":"\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, AcJournalEntry $entry = null): Response
    {
        if(!isset($entry))
        {
            $this->addFlash('error', 'Entry not found');

            return $this->redirectToRoute('entry_index');
        }

        // add missing questions to the edit form
        $entry_answers = $entry->getAnswers();

        $answered_questions = [];
        foreach($entry_answers as $answer)
        {
            $answered_questions[$answer->getQuestion()->getId()] = $answer;
        }

        $entry->clearAnswers();

        $questions = $this->questionRepository->findByEnabled(1);
        foreach($questions as $question)
        {
            if (isset($answered_questions[$question->getId()]))
            {
                // add the previous answer
                $entry->getAnswers()->add($answered_questions[$question->getId()]);
            }
            else
            {
                // add the missing question
                $new_answer = new AcJournalAnswer();
                $new_answer->setQuestion($question);
                $entry->getAnswers()->add($new_answer);
            }
        }

        $form = $this->createForm(AcJournalEntryType::class, $entry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entry = $form->getData();

            // save entry
            $entry->setUpdatedAt(new \DateTime());
            $entityManager->persist($entry);

            // save answers updated date
            foreach($entry->getAnswers() as $answer)
            {
                if (isset($answer) && strlen(trim($answer->getAnswerText())) > 0)
                {
                    if ($answer->getId() != null)
                    {
                        // update existing answer
                        $answer->setUpdatedAt(new \DateTime());
                    }
                    else
                    {
                        // create new answer
                        $answer->setEntry($entry);
                        $answer->setCreatedAt(new \DateTime());
                    }

                    $entityManager->persist($answer);
                }
                else
                {
                    $entry->removeAnswer($answer);
                }
            }

            // save to database
           $entityManager->flush();

            $this->addFlash('success', 'Save successful');

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('entry/edit.html.twig', [
            'form' => $form->createView(),
            'entry_id' => $entry->getId(),
        ]);
    }

    /**
     * @Route("/entry/{id}/delete", name="entry_destroy", requirements={"id":"\d+"})
     */
    public function destroy(Request $request, EntityManagerInterface $entityManager, AcJournalEntry $entry = null): Response
    {
        if(!isset($entry))
        {
            $this->addFlash('error', 'Entry not found');

            return $this->redirectToRoute('entry_index');
        }

        $entityManager->remove($entry);
        $entityManager->flush();

        $this->addFlash('success', 'Delete successful');

        return $this->redirectToRoute('entry_index');
    }
}