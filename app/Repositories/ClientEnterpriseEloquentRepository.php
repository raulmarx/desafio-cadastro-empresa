<?php

namespace App\Repositories;

use App\Models\ClientEnterprise;
use Illuminate\Database\Eloquent\Model;

class ClientEnterpriseEloquentRepository implements ClientEnterpriseRepositoryInterface
{
    public function getModel(): string
    {
        return ClientEnterprise::class;
    }

    public function index(){
        return $this->getModel()::all();
    }

    public function find($id): Model
    {
        return $this->getModel()::find($id ?? null);
    }

    public function create(array $data)
    {
        return $this->getModel()::create($data);
    }

    public function update(array $data,$id)
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->find($id);
        $category->delete();
        return $category;
    }  
}
