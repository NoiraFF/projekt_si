<?php
/**
 * Item controller.
 */

namespace App\Controller;

use App\Entity\Item;
use App\Service\ItemService;
use App\Service\ItemServiceInterface;
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
     * Constructor.
     */
    public function __construct(private readonly ItemServiceInterface $itemService)
    {
    }

    /**
     * Index action.
     * @param int $page Default page number
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'item_index',
        methods: 'GET'
    )]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->itemService->getPaginatedList($page);

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
