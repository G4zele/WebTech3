<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\Security\Core\Security;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Security $security): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $user=$security->getUser();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $article->setArtDateTime(new \DateTime());
            $article->setViews(0);
            $article->setUserRel($user);
            $article->setTitle($form->get('title')->getData());
            $article->setAnnotation($form->get('annotation')->getData());
            $article->setContent($form->get('content')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'article_show', methods: ['GET', 'POST'])]
    public function show(Environment $twig, Article $article, CommentRepository $commentRepository, Request $request, Security $security): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $user=$security->getUser();
        if($user!=null) 
        {
            $article->incrementView();
            // Обновляем сущность поста в БД
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }
         elseif (array_search('ROLE_ADMIN',$user->getRoles())==false && array_search('ROLE_ADMIN',$user->getRoles())!=0) {
            $article->incrementView();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() != false) 
        {
            $commentBody = $form->get('commentBody')->getData();
            $comment = new Comment();
            $comment->setUserRel($user);
            $comment->setText($commentBody);
            $comment->setArticleRel($article);
            $comment->setCommDateTime(new \DateTime());
            $article->addCommRel($comment);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
       }
        return new Response($twig->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $commentRepository->findBy(['articleRel' => $article], ['commDateTime' => 'DESC']),
            'comment_form' => $form->createView(),
        ]));
    }

    #[Route('/{id}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
