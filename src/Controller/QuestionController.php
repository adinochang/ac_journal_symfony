<?php

namespace App\Controller;

use App\Entity\AcJournalQuestion;
use App\Form\AcJournalQuestionType;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $repository = $entityManager->getRepository(AcJournalQuestion::class);
        $questionsQueryBuilder = $repository->getWithSearchQueryBuilder($request->query->get('filter_label'));

        $pagination = $paginator->paginate(
            $questionsQueryBuilder, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            3 /*limit per page*/
        );

        return $this->render('question/index.html.twig', [
            'pagination' => $pagination,
            'filter_label' => $request->query->get('filter_label'),
        ]);
    }

    /**
     * @Route("/question/new", name="question_new")
     */
    public function new(Request $request): Response
    {
        $question = new AcJournalQuestion();

        $form = $this->createForm(AcJournalQuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Save successful');

            return $this->redirectToRoute('question');
        }

        return $this->render('question/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
