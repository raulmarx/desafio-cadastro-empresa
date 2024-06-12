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

        $result = $this->cnpjService->checkCNPJ($cnpj);

        $clientEnterprise = $this->ClientEnterpriseRepository->create([
            'cnpj' => $cnpj,
            'name' => $request->input('name') ?? $result['data']['nome'],
            'fantasy_name' => $request->input('fantasy_name') ?? $result['data']['fantasia'],
            'address' => $request->input('address') ?? $result['data']['logradouro'],
            'headquarters_unit' => $request->input('headquarters_unit') ?? $result['data']['descricao_matriz_filial'],
            'commercial_phone' => $request->input('commercial_phone') ?? $result['data']['telefone'],
            'commercial_email' => $request->input('commercial_email') ?? $result['data']['email'],
            'employee_count' => $request->input('employee_count') ?? $result['data']['qtd_funcionarios'],
            'company_size' => $request->input('company_size') ?? $result['data']['situacao'],
            'business_segment' => $request->input('business_segment') ?? $result['data']['descricao_tipo_empresa'],
            'company_profile' => $request->input('company_profile') ?? $result['data']['descricao_atividade_principal'],
            'structured_hr_department' => $request->input('structured_hr_department') ?? $result['data']['setor_atividade'],
            'responsible_name' => $request->input('responsible_name') ?? $result['data']['nome_responsavel'],
            'responsible_email' => $request->input('responsible_email') ?? $result['data']['email_responsavel'],
            'responsible_whatsapp' => $request->input('responsible_whatsapp') ?? $result['data']['telefone_responsavel'],
            'responsible_phone' => $request->input('responsible_phone') ?? $result['data']['celular_responsavel'],
            'mission' => $request->input('mission') ?? $result['data']['missao'],
            'values' => $request->input('values') ?? $result['data']['visao'],
            'pdi_program' => $request->input('pdi_program') ?? $result['data']['programa_pdhi'],
            'work_regimes' => $request->input('work_regimes') ?? $result['data']['regime_trabalho'],
            'profile_image_path' => $request->input('profile_image_path') ?? $result['data']['logo']

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
