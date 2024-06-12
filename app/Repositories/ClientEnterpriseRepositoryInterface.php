<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;


interface ClientEnterpriseRepositoryInterface
{
    public function getModel(): string;
    
    public function index();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id): Model;
    
}

