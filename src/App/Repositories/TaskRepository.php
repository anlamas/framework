<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TaskRepository extends EntityRepository
{
    /**
     * @param      $currentPage
     * @param      $limit
     * @param null $orderBy
     * @param null $direction
     *
     * @return \App\Services\Paginator
     */
    public function paginate($currentPage, $limit, $orderBy = null, $direction = null)
    {
        $orderByItems = ['finished', 'name', 'email'];
        $directionList = ['asc', 'desc'];

        $orderBy = in_array($orderBy, $orderByItems) ? $orderBy : 'updatedAt';
        $direction = in_array($direction, $directionList) ? $direction : 'desc';

        if ($orderBy === 'updatedAt') {
            $dql = "SELECT t, u from App\Entities\Task t JOIN t.user u ORDER BY t.updatedAt {$direction}";
        } elseif ($orderBy === 'finished') {
            $dql = "SELECT t, u from App\Entities\Task t JOIN t.user u ORDER BY t.finished {$direction}";
        } elseif ($orderBy === 'name') {
            $dql = "SELECT t, u from App\Entities\Task t JOIN t.user u ORDER BY u.name {$direction}";
        } else {
            $dql = "SELECT t, u from App\Entities\Task t JOIN t.user u ORDER BY u.email {$direction}";
        }

        $offset = ($currentPage - 1) * $limit;
        $query = $this->getEntityManager()->createQuery($dql)->setFirstResult($offset)->setMaxResults($limit);

        $paginator = new Paginator($query, true);

        $total = $paginator->count();
        $items = $paginator->getQuery()->getResult();
        $pagination = new \App\Services\Paginator($items, $total, $currentPage, $limit);
        return $pagination;
    }
}
