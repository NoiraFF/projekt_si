<?php

/**
 * Item controller.
 */

namespace App\Controller;

use App\Entity\Item;
use App\Form\Type\ItemType;
use App\Service\ItemServiceInterface;
use App\Security\Voter\ItemVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ItemController.
 */
class ItemController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param ItemServiceInterface $itemService Item service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(private readonly ItemServiceInterface $itemService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Index action.
     *
     * @param int $page Default page number
     *
     * @return Response HTTP response
     */
    #[Route(
        '/item',
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
        '/item/{id}',
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

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/item/create',
        name: 'item_create',
        methods: 'GET|POST',
    )]
    #[IsGranted(ItemVoter::CREATE)]
    public function create(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->itemService->save($item);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('item_index');
        }

        return $this->render(
            'item/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Item    $item    Item entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/item/{id}/edit',
        name: 'item_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    #[IsGranted(ItemVoter::EDIT, subject: 'item')]
    public function edit(Request $request, Item $item): Response
    {
        $form = $this->createForm(
            ItemType::class,
            $item,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('item_edit', ['id' => $item->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->itemService->save($item);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('item_index');
        }

        return $this->render(
            'item/edit.html.twig',
            [
                'form' => $form->createView(),
                'task' => $item,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Item    $item    Item entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/item/{id}/delete',
        name: 'item_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    #[IsGranted(ItemVoter::DELETE, subject: 'item')]
    public function delete(Request $request, Item $item): Response
    {
        $form = $this->createForm(FormType::class, $item, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('item_delete', ['id' => $item->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->itemService->delete($item);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('item_index');
        }

        return $this->render(
            'item/delete.html.twig',
            [
                'form' => $form->createView(),
                'task' => $item,
            ]
        );
    }
}
