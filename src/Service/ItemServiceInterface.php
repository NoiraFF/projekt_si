<?php
/**
 * Item service interface.
 */

namespace App\Service;

use App\Entity\Item;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ItemServiceInterface.
 */
interface ItemServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @parm Item $item Item entity
     */
    public function save(Item $item): void;

    /**
     * Delete entity.
     *
     * @param Item $item Item entity
     */
    public function delete(Item $item): void;

}
