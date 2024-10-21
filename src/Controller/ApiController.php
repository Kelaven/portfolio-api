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
        // Récupère tous les projets depuis la base de données
        $projects = $projectRepository->findAll();


        // Extraire les informations souhaitées de chaque projet
        $projectData = array_map(function ($project) {
            return [
                'name' => $project->getName(),
                'description' => $project->getDescription(),
                'languages' => $project->getLanguages(),
            ];
        }, $projects);


        // Retourne les informations des projets au format JSON
        return $this->json($projectData);
    }
}
