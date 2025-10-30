<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class SortedLinkedListDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    public string $type;

    #[Assert\NotBlank]
    #[Assert\When(
        expression: 'this.type == "integer"',
        constraints: [
            new Assert\All([
                new Assert\Type('int'),
            ]),
        ]
    )]
    #[Assert\When(
        expression: 'this.type == "string"',
        constraints: [
            new Assert\All([
                new Assert\Type('string'),
            ]),
        ],
    )]
    public ?array $list = null;

    public ?string $order = 'asc';
}
