<?php

namespace App\Controller;

use App\Entity\AcJournalQuestion;
use App\Form\AcJournalQuestionType;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(AcJournalQuestion::class);
        $questions = $repository->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
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
dump($question);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            // return $this->redirectToRoute('task_success');
        }

        return $this->render('question/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
