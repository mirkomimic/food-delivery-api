<?php

namespace App\Services\CRUD;

use Illuminate\Http\Request;

abstract class Crud
{
  public abstract function create(Request $request);
  public abstract function read();
  public abstract function update(Request $request, int $id);
  public abstract function delete(int $id);
}
