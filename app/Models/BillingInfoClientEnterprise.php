<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BillingInfoClientEnterprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_enterprise_id', 'billing_address', 'billing_email', 'billing_responsible', 'update_billing_info',
        'payment_methods', 'payment_date', 'contract_type', 'package', 'status'
    ];
    protected $casts = [
        'payment_methods' => 'array',
        'payment_date' => 'date',
        'update_billing_info' => 'boolean',
        'status' => 'boolean',
    ];

    public function clientEnterprise():BelongsToMany
    {
        return $this->belongsToMany(ClientEnterprise::class);
    }
}
