<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\SearchProjectFormType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/project", name="project_")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request,ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        $formSearch = $this->createForm(SearchProjectFormType::class);
        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $search = $formSearch->getData()['search'];
            $projects = $projectRepository->findLikeName($search);
        } else {
            $projects = $projectRepository->findAll();
        }

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'form' => $formSearch->createView(),
        ]);
    }



}
