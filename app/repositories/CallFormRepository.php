<?php

namespace App\Repositories;

use App\interfaces\CallFormRepositoryInterface;
use App\Models\CallForm;
use App\Utils\CallFormSerializer;
use App\Utils\Pagination;
use Leaf\Db;

class CallFormRepository implements CallFormRepositoryInterface
{
    public function __construct(
        protected Db $database,
        protected CallFormSerializer $serializer
    ) {}

    public function create(CallForm $form): void
    {
        $this->database
            ->insert('call_forms')
            ->params($this->serializer->toArray($form));
    }

    /**
     * @return CallForm[]
     */
    public function getAll(Pagination $pagination): array
    {
        $forms = $this->database->query(
            'SELECT * FROM call_forms OFFSET ? LIMIT ?'
        )->bind($pagination->getFirst(), $pagination->getLast())
        ->fetchAll();

        return array_map(
            fn ($params) => $this->serializer->fromArray($params),
            $forms
        );
    }

    public function deleteById(string $id): void
    {
        $this->database->delete('call_forms')
            ->where('id', $id)
            ->execute();
    }
}
