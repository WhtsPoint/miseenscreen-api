<?php

namespace App\Utils;

use App\Dto\FileDto;
use Leaf\Form;

class Validator
{
    public function __construct(
        protected array $fileRules
    ) {}

    public function validate(array $rules, array $data): void
    {
        $form = new Form();

        $isValid = $form::validate($data, $rules);

        if ($isValid === false) {
            $this->response($form::errors());
        }
    }

    /**
     * @param FileDto[] $files
     */
    public function validateFiles(array $files): void
    {
        $allErrors = [];
        $globalErrors = [];
        $fileRules = $this->fileRules;
        $hasErrors = false;

        foreach ($files as $file) {
            $errors = &$allErrors[$file->name];

            if ($file->size > $fileRules['maxSize']) {
                $errors [] = "Invalid file size";
            }

            if (in_array($file->type, $fileRules['approvedFormats']) === false) {
                $errors []= "Invalid file format";
            }

            if ($errors !== null && count($errors) > 0) $hasErrors = true;
        }

        if (count($files) > $fileRules['maxCount']) {
            $globalErrors[] = "Invalid files count";
        }

        if ($hasErrors === true) {
            $this->response(['files' => $allErrors, ...$globalErrors]);
        }
    }

    private function response(array $errors): void
    {
        response()->withHeader('Content-Type', 'application/json');
        response()->exit(json_encode([
            'error' => $errors
        ]), 422);
    }
}
