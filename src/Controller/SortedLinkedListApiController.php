<?php

namespace App\Controller;

use App\DTO\SortedLinkedListDTO;
use App\Entity\SortedLinkedList as SLL;
use App\Service\SortedLinkedListService;
use App\Repository\SortedLinkedListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SortedLinkedList\LinkedList;
use SortedLinkedList\Enum\Sort;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\DBAL\Connection;

class SortedLinkedListApiController extends AbstractController
{
    public function show(): JsonResponse
    {
        $data = [
            'status' => 'success'
        ];

        return new JsonResponse($data);
    }

    public function add(Request $request, SerializerInterface $serializer,): JsonResponse
    {
        $data = $request->getContent();

        try {
            $sll = $serializer->deserialize($data, SLL::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $input = new SortedLinkedListDTO();
        $input->list  = $sll->getList();

        $list = LinkedList::new()->fromArray($input->list);

        $sortedItems = $list->toArray();

        return new JsonResponse(
            json_encode($sortedItems),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    public function remove(Request $request, SerializerInterface $serializer,): JsonResponse
    {
        $data = $request->getContent();

        try {
            $sll = $serializer->deserialize($data, SLL::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $input = new SortedLinkedListDTO();
        $input->list  = $sll->getList();

        $list = LinkedList::new()->fromArray($input->list);

        $sortedItems = $list->toArray();

        return new JsonResponse(
            json_encode($sortedItems),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    public function get(Request $request, SortedLinkedListRepository $sortedLinkedListRepository): JsonResponse
    {
        $entity = $sortedLinkedListRepository->find(SLL::ID);

        $entityList = $entity->getList();
        $list = LinkedList::new()->fromArray($entityList);
        $sortedItems = $list->toArray();

        return new JsonResponse(
            json_encode($sortedItems),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
    public function create(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        SortedLinkedListService $sortedLinkedListService,
        SortedLinkedListRepository $sortedLinkedListRepository
    ): JsonResponse {

        $data = $request->getContent();

        try {
            $sll = $serializer->deserialize($data, SLL::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $input = new SortedLinkedListDTO();
        $input->type = $sll->getType() ?? 'string';
        $input->list  = $sll->getList();

        $violations = $validator->validate($input);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $v) {
                $errors[$v->getPropertyPath()][] = $v->getMessage();
            }
            return $this->json(['errors' => $errors], 422);
        }

        $sll = $sortedLinkedListService->manageSortedLinkedList($input);

        $jsonResponse = $serializer->serialize($sll, 'json');

        return new JsonResponse(
            $jsonResponse,
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
}
