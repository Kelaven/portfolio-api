<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/api/projects', name: 'api_projects', methods: ['GET'])]
    public function getProjects(ProjectRepository $projectRepository): JsonResponse
    {
        // $projects = $projectRepository->findAll();         // Récupère tous les projets depuis la base de données
        // Récupère tous les projets non archivés grâce au ProjectRepository :
        $projects = $projectRepository->findActiveProjects();


        // Extraire les informations souhaitées de chaque projet
        $projectData = array_map(function ($project) {
            return [
                'name' => $project->getName(),
                'description' => $project->getDescription(),
                'languages' => $project->getLanguages(),
                'picture' => $this->getParameter('app.base_url') . '/uploads/images/' . $project->getPicture(),
            ];
        }, $projects);


        // Retourne les informations des projets au format JSON
        return $this->json($projectData);
    }
}
