<?php

namespace App\Service;

use App\DTO\SortedLinkedListDTO;
use App\Entity\SortedLinkedList;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SortedLinkedListRepository;

class SortedLinkedListService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SortedLinkedListRepository $sortedLinkedListRepository
    ) {
    }

    public function manageSortedLinkedList(SortedLinkedListDTO $dto): SortedLinkedList
    {
        $sorted_linked_list = $this->sortedLinkedListRepository->find(SortedLinkedList::ID);

        $sorted_linked_list->setType($dto->type);
        $sorted_linked_list->setList($this->sortedList($dto->list, $dto->order));
        $sorted_linked_list->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($sorted_linked_list);
        $this->entityManager->flush();

        return $sorted_linked_list;

        // // Business logic starts here
        // $user = new SortedLinkedList();
        // $user->setUsername($dto->username);
        // $user->setEmail($dto->email);

        // $hashedPassword = $this->passwordHasher->hashPassword(
        //     $user,
        //     $dto->password
        // );
        // $user->setPassword($hashedPassword);

        // // Persist the new user
        // $this->entityManager->persist($user);
        // $this->entityManager->flush();

        // return $user;
    }

    private function sortedList(array $list, string $order): array
    {
        if ($order === "asc") {
            rsort(array: $list);
        } else {
            arsort(array: $list);
        }

        return $list;
    }
}
