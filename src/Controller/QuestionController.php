<?php

namespace App\Controller;

use App\Entity\AcJournalQuestion;
use App\Form\AcJournalQuestionType;
use App\Repository\AcJournalQuestionRepository;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class QuestionController extends AbstractController
{
    private $questionRepository;

    public function __construct(AcJournalQuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @Route("/question", name="question")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $questionsQueryBuilder = $this->questionRepository->getWithSearchQueryBuilder($request->query->get('filter_label'));

        $pagination = $paginator->paginate(
            $questionsQueryBuilder, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->render('question/index.html.twig', [
            'pagination' => $pagination,
            'filter_label' => $request->query->get('filter_label'),
        ]);
    }

    /**
     * @Route("/question/new", name="question_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $question = new AcJournalQuestion();

        $form = $this->createForm(AcJournalQuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());

            // save to database
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Save successful');

            return $this->redirectToRoute('question');
        }

        return $this->render('question/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/question/{id}", name="question_edit", requirements={"id":"\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, AcJournalQuestion $question = null): Response
    {
        if(!isset($question))
        {
            $this->addFlash('error', 'Question not found');

            return $this->redirectToRoute('question');
        }

        $form = $this->createForm(AcJournalQuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());

            // save to database
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Save successful');

            return $this->redirectToRoute('question');
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
            'question_id' => $question->getId(),
        ]);
    }

    /**
     * @Route("/question/{id}/delete", name="question_destroy", requirements={"id":"\d+"})
     */
    public function destroy(Request $request, EntityManagerInterface $entityManager, AcJournalQuestion $question = null): Response
    {
        if(!isset($question))
        {
            $this->addFlash('error', 'Question not found');

            return $this->redirectToRoute('question');
        }

        $entityManager->remove($question);
        $entityManager->flush();

        $this->addFlash('success', 'Delete successful');

        return $this->redirectToRoute('question');
    }
}
