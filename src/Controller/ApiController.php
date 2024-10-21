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


        // if (empty($projects)) {
        //     return $this->json(['message' => 'Aucun projet trouvé'], 404);
        // } else {
        //     var_dump($projects);
        // }


        // Retourne les projets au format JSON
        return $this->json($projects);
    }
}
