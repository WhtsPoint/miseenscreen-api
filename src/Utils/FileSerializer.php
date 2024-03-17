<?php

namespace App\Utils;

use App\Dto\FileDto;

class FileSerializer
{
    /**
     * @return FileDto[]
     */
    public function toCorrectFormat(array $files): array
    {
        $result = [];

        if (gettype(@$files['name']) !== 'array') return [];

        foreach (array_keys(@$files['name'] ?: []) as $i) {
            $result []= new FileDto(
                $files['name'][$i],
                $files['full_path'][$i],
                $files['type'][$i],
                $files['tmp_name'][$i],
                $files['size'][$i]
            );
        }

        return $result;
    }
}
