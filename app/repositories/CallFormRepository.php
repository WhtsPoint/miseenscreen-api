<?php

namespace App\Repositories;

use App\Exceptions\CallFormNotFoundException;
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
            ->params([
                ...$this->serializer->toArray($form),
                'files' => json_encode($form->getFiles()),
                'services' => json_encode($form->getServices()->get())
            ])->execute();
    }

    /**
     * @throws CallFormNotFoundException
     */
    public function getById(string $id): CallForm
    {
        $params = $this->database->query(
            'SELECT * FROM call_forms WHERE id = ?'
        )->bind($id)->first();

        if ($params === false) {
            throw new CallFormNotFoundException();
        }

        return $this->serializer->fromArray($params);
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

    /**
     * @throws CallFormNotFoundException
     */
    public function deleteById(string $id): void
    {
        if ($this->isExists($id) === false) {
            throw new CallFormNotFoundException();
        }

        $this->database->delete('call_forms')
            ->where('id', $id)
            ->execute();
    }

    public function isExists(string $id): bool
    {
        return $this->database->query('SELECT COUNT(*) AS count FROM call_forms WHERE id = ?')
            ->bind($id)->fetchAll()[0]['count'] !== 0;
    }
}
