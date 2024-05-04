<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'welcome', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['status' => true, 'message' => 'Welcome to Api World']);
    }
}
