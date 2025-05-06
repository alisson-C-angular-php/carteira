<?php

namespace App\Domain\Interfaces;

use CodeIgniter\HTTP\Request;

interface UserInterface{
public function save(Request $request);

public function findAll();


public function delete(int $id): bool;
public function update(Request $request);
}