<?php

namespace App\Services\FilesCrud;

use Illuminate\Support\Facades\Storage;

class SingleFileCrud
{
  public function save(string $path, object $file): void
  {
    Storage::put("public/{$path}", $file);
  }

  public function delete(string $path, string $image): void
  {
    if (Storage::disk('public')->exists("{$path}/{$image}")) {
      Storage::disk('public')->delete("{$path}/{$image}");
    }
  }
}
