<?php

namespace App\Controller;

use App\Entity\AcJournalEntry;
use App\Form\AcJournalEntryType;
use App\Repository\AcJournalEntryRepository;

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

    public function __construct(AcJournalEntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
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

    }


    /**
     * @Route("/entry/{id}", name="entry_edit", requirements={"id":"\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, AcJournalEntry $question = null): Response
    {

    }
}