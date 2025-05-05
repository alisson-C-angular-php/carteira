<?php

namespace App\Interfaces;

use CodeIgniter\HTTP\Request;

interface UserInterface{
    public function save(Request $request);

    public function select();

    public function delete(Request $request);

    public function update(Request $request);
}