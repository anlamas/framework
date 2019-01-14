<?php

namespace App\Services;

use App\Entities\Task;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Rakit\Validation\Validator;

class TaskService
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * TaskService constructor.
     *
     * @param EntityManagerInterface $manager
     * @param Validator              $validator
     */
    public function __construct(EntityManagerInterface $manager, Validator $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function store(array $attributes = [])
    {
        $validation = $this->validator->validate($attributes, [
            'name' => 'required|min:3|max:15',
            'email' => 'required|email',
            'body' => 'required|min:3|max:255',
        ]);

        if ($validation->fails()) {
            return ['errors' => $validation->errors()->toArray()];
        }

        try {
            $userRepository = $this->manager->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $attributes['email']]);

            if (is_null($user)) {
                $user = new User($attributes['name'], $attributes['email'], new \DateTimeImmutable());
            }

            $task = new Task($attributes['body'], new \DateTimeImmutable(), $user);

            $this->manager->beginTransaction();
            $this->manager->persist($user);
            $this->manager->persist($task);
            $this->manager->flush();
            $this->manager->commit();

        } catch (\Exception $exception) {
            $this->manager->rollback();
            return ['errors' => 'Не удалось создать задание'];
        }
        return ['data' => $task->toArray()];
    }

    /**
     * @param int $id
     * @param array $attributes
     *
     * @return array
     */
    public function update($id, array $attributes)
    {
        $repository = $this->manager->getRepository(Task::class);
        $task = $repository->find($id);
        if (is_null($task)) {
            return ['errors' => "Задача с id {$id} не найдена"];
        }
        $task->edit($attributes['body']);
        $task->setStatus($attributes['finished']);
        $this->manager->persist($task);
        $this->manager->flush();
        return ['data' => $task->toArray()];
    }

    /**
     * @param $attributes
     *
     * @return Paginator
     */
    public function paginate($attributes)
    {
        $repository = $this->manager->getRepository(Task::class);

        $orderBy = $attributes['orderBy'] ?? null;

        $direction = $attributes['direction'] ?? null;

        $currentPage = $attributes['page'] ?? 0;

        $limit = $attributes['limit'] ?? 3;

        return $repository->paginate($currentPage, $limit, $orderBy, $direction);
    }
}
