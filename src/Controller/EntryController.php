<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class EntryController extends AbstractController
{
    public function home(Environment $twigEnvironment) {
        return new Response(
            $twigEnvironment->render('home.html.twig')
        );
    }
}