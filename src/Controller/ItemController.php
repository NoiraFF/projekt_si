<?php
/**
 * Item controller.
 */

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class ItemController.
 */
#[Route('/item')]
class ItemController extends AbstractController
{
    /**
     * Index action.
     *
     * @param ItemRepository     $itemRepository Item repository
     * @param PaginatorInterface $paginator      Paginator
     * @param int                $page           Default page number
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'item_index',
        methods: 'GET'
    )]
    public function index(ItemRepository $itemRepository, PaginatorInterface $paginator, #[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $paginator->paginate(
            $itemRepository->queryAll(),
            $page,
            ItemRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'sortFieldAllowList' => ['item.id', 'item.title', 'item.description', 'item.createdAt'],
                'defaultSortFieldName' => 'item.createdAt',
                'defaultSortDirection' => 'desc',
            ]
        );

        return $this->render('item/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * View action.
     *
     * @param Item $item Item entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'item_view',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function view(Item $item): Response
    {
        return $this->render(
            'item/view.html.twig',
            ['item' => $item]
        );
    }
}
