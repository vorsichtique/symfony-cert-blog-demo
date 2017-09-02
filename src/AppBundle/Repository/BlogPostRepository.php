<?php


namespace AppBundle\Repository;


use AppBundle\Controller\BlogController;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class BlogPostRepository extends EntityRepository
{

    public function findCurrent($page = 0){
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p,t
                FROM AppBundle:BlogPost p
                LEFT JOIN p.tags t
        ');

        return $this->createPaginator($query, $page);
    }

    private function createPaginator(Query $query, $page)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(BlogController::ITEMS_PER_PAGE);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}