<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Service;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyCollection;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //$companies = Company::all();
        $companies = DB::table('companies')->get();
        if(count($companies)>0){
            return response()->json([
                "data" => $companies
            ]);
        }else{
            return response()->json([
                "message" => "No data found",
            ],404);
        }
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     */
    public function store(Request $request)
    {
        if (Request::capture()->expectsJson())
        {  
            $request->validate([
                'name' => ['required'],
                'company_code' => ['required'],
                'type' => ['required', Rule::in(['UAB','uab','VsI','vsi','VšĮ','všį'])],
                'email' => ['required'],
                'city' => ['required'],
                'postal_code' => ['required'],
                'address' => ['required']
            ]);
            //Iterpia i duomenu baze
            $temp =  Company::create($request->all());

            return response()->json([
                "data" => array_merge($request->all(), ['id'=> $temp["id"]]),
                "additional" => "empty"
            ],201);
        }
        else
        {  
            return response()->json([
                "message" => "Miss header accept application/json",
            ],403);    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($company)
    {
        $temp = Company::find($company);
        if(is_null($temp)){
            return response()->json([
                "message" => "Data not found"
            ],404);
        }else{
            return response()->json([
                "data" => $temp
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\JsonResponse
     * @return \Illuminate\Http\Response
     * 
     */
    public function update($id,Request $request)
    {
        if (Request::capture()->expectsJson()  )
        {  
            $temp = Company::find($id);
            if(is_null($temp)){
                return response()->json([
                    "message" => "Company not found"
                ],404);
            }

            json_decode($request->getContent());

            if (json_last_error() != JSON_ERROR_NONE) {
                // There was an error
                return response()->json([
                    "message" => "Bad json"
                ],400);
            }

            $request->validate([
                'name' => ['sometimes','required', 'string'],
                'company_code' => ['sometimes','required', 'int'],
                'type' => ['sometimes','required', Rule::in(['UAB','uab','VsI','vsi','VšĮ','všį'])],
                'email' => ['sometimes','required', 'mail'],
                'city' => ['sometimes','required', 'string'],
                'postal_code' => ['sometimes','required', 'int'],
                'address' => ['sometimes','required', 'string']
            ]);

            $temp->update($request->all());

            return response()->json([
                "data" => $request->all(),
                "UpdatedCompany" =>   $temp
            ]);
        }
        else
        {  
            return response()->json([
                "message" => "Miss header accept application/json",
            ],403);    
        }
        // $company->update( $request->all());
        // return new \Illuminate\Http\JsonResponse([
        //     'data' => 'updated'
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Company $company)
    {
        $temp = Company::find($company);
        $result =$company->forceDelete();
        if($result){
            return new \Illuminate\Http\JsonResponse([
                'message'=> 'company deleted',
                'data' => $temp
            ]);
        }
    }
}
