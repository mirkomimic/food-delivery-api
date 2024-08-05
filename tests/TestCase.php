<?php

namespace Tests;

use App\Services\FilesCrud\SingleFileCrud;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
  public function deleteImage(string $path, string $image): void
  {
    if (Storage::disk('public')->exists("{$path}/{$image}")) {
      Storage::disk('public')->delete("{$path}/{$image}");
    }
  }
}
