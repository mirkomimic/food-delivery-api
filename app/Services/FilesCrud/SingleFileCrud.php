<?php

namespace App\Services\FilesCrud;

use Illuminate\Support\Facades\Storage;

class SingleFileCrud
{
  public function save(string $path, object $file): void
  {
    Storage::put("public/{$path}", $file);
  }
}
