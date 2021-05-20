<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(Environment $twig, ArticleRepository $articleRepository): Response
    {
        return new Response($twig->render('home_page/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['artDateTime'=>'DESC']),
        ]));
    }
}
