<?php

/**
 * Comment service interface.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Item;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Comment CommentServiceInterface.
 */
interface CommentServiceInterface
{
    /**
     * Get paginated list for item.
     *
     * @param int  $page Page number
     * @param Item $item Item entity
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListForItem(int $page, Item $item): PaginationInterface;

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
     * @param Comment $comment Comment entity
     */
    public function save(Comment $comment): void;

    /**
     * Delete entity.
     *
     * @param Comment $comment Comment entity
     */
    public function delete(Comment $comment): void;
}
