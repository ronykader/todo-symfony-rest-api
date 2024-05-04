<?php

namespace App\Service\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

readonly class TaskService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TaskValidatorService   $taskValidatorService
    )
    {
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        try {
            $task = new Task();
            $task->setName($data['name']);
            $task->setDeadline(new \DateTime($data['deadline']));
            $task->setCompleted(false);

            $validationResult = $this->taskValidatorService->validatorsTaskData($task);
            if (!$validationResult['status']) {
                return $validationResult;
            }
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            return [
                'status' => true,
                'message' => 'Success! The task has been added',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }


    public function update(array $data, $task): array
    {
        try {
            if (empty($task)) {
                return [
                    'status' => false,
                    'message' => 'This task not found in the database please try with valid info',
                ];
            }
            $task->setCompleted($data['completed']);
            $validationResult = $this->taskValidatorService->validatorsTaskData($task);
            if (!$validationResult['status']) {
                return $validationResult;
            }
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            return [
                'status' => true,
                'message' => 'Success! The data has been updated',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }

    }


    /**
     * @param object $task
     * @return array
     */
    public function destroy(object $task): array
    {
        try {
            if (empty($task)) {
                return [
                    'status' => false,
                    'message' => 'Task not found. Please try with valid task id',
                ];
            }
            $this->entityManager->remove($task);
            $this->entityManager->flush();
            return [
                'status' => true,
                'message' => 'Success! The task has been deleted.',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }


}
