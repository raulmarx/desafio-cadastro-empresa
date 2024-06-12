<?php

namespace App\Repositories;

use App\Models\BillingInfoClientEnterprise;
use Illuminate\Database\Eloquent\Model;

class BillingInfoClientEnterpriseEloquentRepository implements BillingInfoClientEnterpriseRepositoryInterface
{
    public function getModel(): string
    {
        return BillingInfoClientEnterprise::class;
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
