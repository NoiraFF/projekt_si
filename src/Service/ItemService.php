<?php

/**
 * Item service.
 */

namespace App\Service;

use App\Repository\ItemRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ItemService.
 */
class ItemService implements ItemServiceInterface
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    private const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ItemRepository     $itemRepository Item repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(private readonly ItemRepository $itemRepository, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->itemRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE,
            [
                'sortFieldAllowList' => ['item.id', 'item.title', 'item.description', 'item.createdAt'],
                'defaultSortFieldName' => 'item.createdAt',
                'defaultSortDirection' => 'desc',
            ]
        );
    }
}
