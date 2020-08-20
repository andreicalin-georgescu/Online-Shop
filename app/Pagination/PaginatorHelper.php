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
    protected $defaultSortField;
    protected $sortDirection;
    protected $sortReverse;

    // Filter array

    protected $filter;

    public function __construct(EntityManager $db, int $pageSize = 20, string $defaultSortField = name)
    {
        $this->db = $db;
        $this->pageSize = $pageSize;
        $this->totalRecords = $this->getTotal();
        $this->defaultSortField = $defaultSortField;
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

    public function setFilter($request)
    {
        $this->filter = [];

        if (empty($request->getQueryParams()['filter'])) {
            $filters = [];
        } else {
            $filters = $request->getQueryParams()['filter'];
        }

        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                if (!empty($value) || $value == '0') {
                    $this->filter[$key] = $value;
                }
            }
        }
    }

    protected function getTotal()
    {
        $total = $this->db->getRepository(Product::class)
                    ->createQueryBuilder('p')
                    ->select('count(p.id)');

        if (!empty($this->filter)) {
            foreach ($this->filter as $key => $value) {
                if ($this->db->getClassMetadata(Product::class)->hasField($key)) {
                    $total = $total->andWhere("p.{$key} LIKE :{$key}");

                    if ($this->db->getClassMetadata(Product::class)->getTypeOfField($key) === 'string' ||
                        $this->db->getClassMetadata(Product::class)->getTypeOfField($key) === 'text') {

                        $total = $total->setParameter($key, '%' . $value . '%');
                    } else {
                        $total = $total->setParameter($key, $value);
                    }
                }
            }
        }

        $total = $total->getQuery()->getSingleScalarResult();

        return $total;
    }

    public function setCurrentPage($request)
    {
        if (empty($request->getQueryParams()['page'])) {
            $page = 1;
        } else {
            $page = $request->getQueryParams()['page'];
        }

        $currentPage = $page;

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

    public function setSorting($request)
    {
        if (!empty($request->getQueryParams()['sort'])) {
            $sort = $request->getQueryParams()['sort'];
        }

        if (empty($sort) && empty($this->defaultSortField)) {
            $this->sortField = '';
            $this->sortDirection = '';
        } else {
            if (empty($sort)) {
                $arr = explode('.', $this->defaultSortField);
            } else {
                $arr = explode('.', $sort);
            }

            if (empty($arr[0])) {
                $this->sortField = '';
                $this->sortDirection = '';
            } else if (count($arr) == 1 || empty($arr[1])) {
                $this->sortField = $arr[0];
                $this->sortDirection = 'ASC';
                $this->sortReverse = $this->sortField . '.desc';
            } else {
                $this->sortField = $arr[0];
                if (strtolower($arr[1] == 'desc')) {
                    $this->sortDirection = 'DESC';
                    $this->sortReverse = $this->sortField . '.asc';
                } else {
                    $this->sortDirection = 'ASC';
                    $this->sortReverse = $this->sortField . '.desc';
                }
            }

            // Validate sort field
            if (!$this->db->getClassMetadata(Product::class)->hasField($this->sortField)) {
                $this->sortField = '';
                $this->sortDirection = '';
            }
        }
    }

    /**
     * Get the records for the current page
     */

    public function getRecords()
    {
        $records = $this->db->getRepository(Product::class)
                        ->createQueryBuilder('p');
        if (!empty($this->sortField)) {
            $records = $records->orderBy('p.' . $this->sortField, $this->sortDirection);
        }

        if (!empty($this->filter)) {
            foreach ($this->filter as $key => $value) {
                if ($this->db->getClassMetadata(Product::class)->hasField($key)) {
                    $records = $records->andWhere("p.{$key} LIKE :{$key}");
                    if ($this->db->getClassMetadata(Product::class)->getTypeOfField($key) === 'string' ||
                        $this->db->getClassMetadata(Product::class)->getTypeOfField($key) === 'text') {

                        $records = $records->setParameter($key, '%' . $value . '%');
                    } else {
                        $records = $records->setParameter($key, $value);
                    }
                }
            }
        }

        $records = $records->setFirstResult($this->offset)
                ->setMaxResults($this->pageSize)
                ->getQuery()
                ->getResult();
        return $records;
    }

    public function getDisplayParameters()
    {
        $return = [
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
            'sortField' => $this->sortField,
            'sortOrder' => $this->sortDirection,
            'sortReverse' => $this->sortReverse
        ];

        if (empty($this->sortField)) {
            $return['sort'] = '';
        } else {
            $return ['sort'] = $this->sortField . '.' . strtolower($this->sortDirection);
        }

        return $return;
    }
}
 ?>
