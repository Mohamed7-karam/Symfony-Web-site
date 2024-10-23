<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Services\ManageFile;
use App\Services\CategoriesServices;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/account')]
class ArticleController extends AbstractController
{
    private $manageFile;
    private $em;
    public function __construct(CategoriesServices $categoriesServices, ManageFile $manageFile, EntityManagerInterface $em){
        $categoriesServices->updateSession();
        $this->manageFile = $manageFile;
        $this->em = $em;
    }
    #[Route('/', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
       

        return $this->render('article/index.html.twig', [
            // 'articles' => $articles,
        ]);
    }
    #[Route('/articles', name: 'app_article_index', methods: ['GET'])]
    public function articles(ArticleRepository $articleRepository): Response
    {
        $user = $this->getUser();

        if(!$user){
            // Error
        }
        $articles = $articleRepository->findByAuthor($user);

        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTimeImmutable());

            $file = $form["imageFile"]->getData();

            $file_url = $this->manageFile->saveFile($file);

            $article->setImageUrl($file_url);
            $article->setAuthor($this->getUser());


            $this->em->persist($article);
            $this->em->flush();

            // $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article, ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();

        return $this->render('blog/single.html.twig', [
            'article' => $article,
            'articles' => $articles,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new \DateTimeImmutable());

            $file = $form["imageFile"]->getData();
            if($file){
                $file_url = $this->manageFile->updateFile($file, $article->getImageUrl());
                
                $article->setImageUrl($file_url);
                
            }

            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute('app_single_article', ["slug"=>$article->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $imageUrl = $article->getImageUrl();
            $articleRepository->remove($article, true);
            $this->manageFile->removeFile($imageUrl);

        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
