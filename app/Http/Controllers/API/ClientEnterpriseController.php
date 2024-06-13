<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\ClientEnterpriseRepositoryInterface;
use App\Services\CNPJService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientEnterpriseController extends Controller
{
    protected $cnpjService;

    public function __construct(CNPJService $cnpjService, private ClientEnterpriseRepositoryInterface $ClientEnterpriseRepository)
    {
        $this->cnpjService = $cnpjService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientEnterprise = $this->ClientEnterpriseRepository->index();

        foreach ($clientEnterprise as $key => $value) {

            $billingInfo = $value->BillingInfoClientEnterprise()
                ->where('client_enterprise_id', $value->id)
                ->get();

            $clientEnterprise[$key]['billing_info'] = $billingInfo;
        }

        return response()->json($clientEnterprise);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'cnpj' => '',
            'name' => '',
            'fantasy_name' => '',
            'address' => '',
            'headquarters_unit' => '',
            'commercial_phone' => '',
            'commercial_email' => '',
            'employee_count' => '',
            'company_size' => '',
            'business_segment' => '',
            'company_profile' => '',
            'structured_hr_department' => '',
            'responsible_name' => '',
            'responsible_email' => '',
            'responsible_whatsapp' => '',
            'responsible_phone' => '',
            'mission' => '',
            'values' => '',
            'pdi_program' => '',
            'work_regimes' => '',
            'profile_image_path' => '',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        };
        $cnpj = $request->input('cnpj');

        $clientEnterprise = $this->ClientEnterpriseRepository->create([
            'cnpj' => $cnpj,
            'name' => $request->input('name') ,
            'fantasy_name' => $request->input('fantasy_name') ,
            'address' => $request->input('address') ,
            'headquarters_unit' => $request->input('headquarters_unit') ,
            'commercial_phone' => $request->input('commercial_phone') ,
            'commercial_email' => $request->input('commercial_email') ,
            'employee_count' => $request->input('employee_count') ,
            'company_size' => $request->input('company_size') ,
            'business_segment' => $request->input('business_segment') ,
            'company_profile' => $request->input('company_profile') ,
            'structured_hr_department' => $request->input('structured_hr_department') ,
            'responsible_name' => $request->input('responsible_name') ,
            'responsible_email' => $request->input('responsible_email') ,
            'responsible_whatsapp' => $request->input('responsible_whatsapp') ,
            'responsible_phone' => $request->input('responsible_phone') ,
            'mission' => $request->input('mission') ,
            'values' => $request->input('values') ,
            'pdi_program' => $request->input('pdi_program') ,
            'work_regimes' => $request->input('work_regimes') ,
            'profile_image_path' => $request->input('profile_image_path') ,

        ]);

        $billingInfo = $this->ClientEnterpriseRepository->BillingInfoClientEnterprise()->create([
            'client_enterprise_id' => $clientEnterprise->id,
            'billing_address' => $request->input('billing_address'),
            'billing_email' => $request->input('billing_email'),
            'billing_responsible' => $request->input('billing_responsible'),
            'update_billing_info' => $request->input('update_billing_info'),
            'payment_methods' => $request->input('payment_methods'),
            'payment_date' => $request->input('payment_date'),
            'contract_type' => $request->input('contract_type'),
            'package' => $request->input('package'),
            'status' => $request->input('status'),

        ]);


        return response()->json([$clientEnterprise,$billingInfo]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
