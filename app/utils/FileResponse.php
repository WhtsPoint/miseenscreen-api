<?php

namespace App\Utils;

class FileResponse
{
    public function response(string $file): void
    {
        header('Content-Type:' . finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file));
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Length:' . filesize($file));
        readfile($file);
        ob_clean();
        flush();
    }
}
