<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Service\Task\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{

    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly TaskService $taskService
    )
    {
    }

    /**
     * @return JsonResponse
     */
    #[Route('/api/tasks', name: 'task.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->getTaskData();
        return $this->json($tasks);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/api/task/create', name: 'task.create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $result = $this->taskService->store($data);
        if ($result['status'] === true) {
            return $this->json($result['message'], Response::HTTP_CREATED);
        }
        return $this->json($result['message'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * @param Request $request
     * @param Task $task
     * @return Response
     */

    #[Route('/api/tasks/{task}/update', name: 'tasks.update', methods: ['PUT'])]
    public function update(Request $request, Task $task): Response
    {
        $data = json_decode($request->getContent(), true);
        $result = $this->taskService->update($data, $task);
        if ($result['status'] === true) {
            return $this->json($result['message'], Response::HTTP_OK);
        }
        return $this->json($result['message'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * @param Task $task
     * @return JsonResponse
     */
    #[Route('/api/tasks/{task}/delete', name: 'tasks.delete', methods: ['DELETE'])]
    public function destroy(Task $task): JsonResponse
    {
        $result = $this->taskService->destroy($task);
        if ($result['status'] === true) {
            return $this->json($result['message'], Response::HTTP_OK);
        }
        return $this->json($result['message'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


}
