<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return array
     */
    public function getTaskData(): array
    {
        return $this->createQueryBuilder('task')
            ->select('task.id', 'task.name', 'task.deadline', 'task.completed')
            ->orderBy('task.id', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }
}
