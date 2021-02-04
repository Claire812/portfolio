<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Project;
use App\Form\LanguageType;
use App\Form\ProjectType;
use App\Repository\LanguageRepository;
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
    public function index(Request $request, EntityManagerInterface $entityManager, ProjectRepository $projectRepository, LanguageRepository $languageRepository): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
        }


        $language = new Language();
        $formLanguage = $this->createForm(LanguageType::class, $language);
        $formLanguage->handleRequest($request);
        if ($formLanguage->isSubmitted() && $formLanguage->isValid()) {
            $entityManager->persist($language);
            $entityManager->flush();
        }

        $projects = $projectRepository->findAll();
        $languages = $languageRepository->findAll();


        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'form_language' => $formLanguage->createView(),
            'projects' => $projects,
            'languages' => $languages,
        ]);
    }

    /**
     * @Route("/edit/{id}", methods={"GET", "POST"}, name="edit")
     *
     */
    public function editProject(Project $project, int $id, Request $request, ProjectRepository $projectRepository)
    {
        $project = $projectRepository->findOneBy(['id' => $id]);

        $formEditProject = $this->createForm(ProjectType::class, $project);
        $formEditProject->handleRequest($request);
        if ($formEditProject->isSubmitted() && $formEditProject->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project_index');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $formEditProject->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/edit/language/{id}", methods={"GET", "POST"}, name="edit_language")
     *
     */
    public function editLanguage(Language $language, int $id, Request $request, LanguageRepository $languageRepository)
    {
        $language = $languageRepository->findOneBy(['id' => $id]);

        $formEditLanguage = $this->createForm(LanguageType::class, $language);
        $formEditLanguage->handleRequest($request);
        if ($formEditLanguage->isSubmitted() && $formEditLanguage->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/edit_language.html.twig', [
            'form' => $formEditLanguage->createView(),
            'language' => $language,
        ]);
    }
}
