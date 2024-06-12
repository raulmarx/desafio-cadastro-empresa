<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientEnterprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj', 'name', 'fantasy_name', 'address', 'headquarters_unit', 'commercial_phone', 'commercial_email',
        'employee_count', 'company_size', 'business_segment', 'company_profile', 'structured_hr_department',
        'responsible_name', 'responsible_email', 'responsible_whatsapp', 'responsible_phone', 'mission', 'values',
        'pdi_program', 'work_regimes', 'profile_image_path'
    ];
    protected $casts = [
        'is_head_office' => 'boolean',
        'structured_hr_department' => 'boolean',
        'pdi_program' => 'boolean',
        'work_regimes' => 'array',
    ];
    public function BillingInfoClientEnterprise(): HasMany
    {
        return $this->hasMany(BillingInfoClientEnterprise::class, 'client_enterprise_id');
    }
}
