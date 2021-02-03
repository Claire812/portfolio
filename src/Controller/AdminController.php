<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Poster;
use App\Entity\Project;
use App\Form\LanguageType;
use App\Form\PosterType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
        }



        $poster = new Poster();
        $formPoster = $this->createForm(PosterType::class, $poster);
        $formPoster->handleRequest($request);
        if ($formPoster->isSubmitted() && $formPoster->isValid()) {
            $entityManager->persist($poster);
            $entityManager->flush();
        }

        $language = new Language();
        $formLanguage = $this->createForm(LanguageType::class, $language);
        $formLanguage->handleRequest($request);
        if ($formLanguage->isSubmitted() && $formLanguage->isValid()) {
            $entityManager->persist($language);
            $entityManager->flush();
        }



        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'form_poster' => $formPoster->createView(),
            'form_language' => $formLanguage->createView(),
        ]);
    }
}
