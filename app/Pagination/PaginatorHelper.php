<?php

namespace Shop\Pagination;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Shop\Models\Product;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class to generate pagination for items
 */
class PaginatorHelper
{
    protected $db;

    // Number of records per page

    protected $pageSize;

    // Current page number

    protected $currentPage;

    // Total number of pages

    protected $totalPages;

    // Total records

    protected $totalRecords;

    // Offset of the current page for db table

    protected $offset;

    // Sort field

    protected $sortField;

    public function __construct(EntityManager $db, int $pageSize = 20, string $defaultSortField = NULL)
    {
        $this->db = $db;
        $this->pageSize = $pageSize;
        $this->sortField = $defaultSortField;
        $this->totalRecords = $this->getTotal();
    }

    public function getPostsFromDB()
    {
        $query = $this->db->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->getQuery()
            ->setFirstResult(0)
            ->setMaxResults(10);

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        $c = count($paginator);

        foreach ($paginator as $post) {
            echo $post->getHeadline() . "\n";
        }
    }

    protected function getTotal()
    {
        $total = $this->db->getRepository(Product::class)
                    ->createQueryBuilder('p')
                    ->select('count(p.id)')
                    ->getQuery()
                    ->getSingleScalarResult();
        return $total;
    }

    public function setCurrentPage($currentURI)
    {
        $tmp = explode('=', trim($currentURI->getQuery(),'/'));
        $currentPage = end($tmp);

        $this->currentPage = $currentPage;
        if (empty($this->currentPage)) {
            $this->currentPage = 1;
        }

        $this->totalPages = ceil($this->totalRecords / $this->pageSize);
        if ($this->currentPage * $this->pageSize > $this->totalRecords) {
            $this->currentPage = $this->totalPages;
        }

        if ($this->currentPage > 1) {
            $this->offset = ($this->currentPage - 1) * $this->pageSize;
        } else {
            $this->offset = 0;
        }
    }

    public function getRecords()
    {
        $records = $this->db->getRepository(Product::class)
                        ->createQueryBuilder('p')
                        ->orderBy('p.' . $this->sortField, 'DESC')
                        ->setFirstResult($this->offset)
                        ->setMaxResults($this->pageSize)
                        ->getQuery()
                        ->getResult();
        return $records;
    }

    public function getDisplayParameters()
    {
        return [
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages
        ];
    }

}

 ?>
