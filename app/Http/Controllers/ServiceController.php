<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Company;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_id)
    {
        $temp = Company::find($company_id);
        if(is_null($temp)){
            return response()->json([
                "message" => "Data not found (company)"
            ],404);
        }else{
            $services = DB::table('services')->where('company_id',"=",$company_id )->get();
            if(count($services)==0){
                return response()->json([
                    "message" => "Data not found"
                ]);
            }else{
                return response()->json([
                    "data" => $services
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request
     */
    public function store($company, Request $request)
    {
        if (Request::capture()->expectsJson())
        {  
            $temp = Company::find($company);
            if(is_null($temp)){
                return response()->json([
                    "message" => "Data not found (company)"
                ],404);
            }
            $request->validate([
                'name' => ['required','string'],
                'description' => ['required', 'string'],
                'price' => ['required','numeric', 'between:0.00,9999.99']
            ]);
            Service::create(array_merge($request->all(), ['company_id'=> $company]));
            return response()->json([
                "data" => $request->all()
            ]);
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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request
     */
    public function show($company, $service, Request $request)
    {
        $temp = Company::find($company);
        if(is_null($temp)){
            return response()->json([
                "message" => "Data not found (company)"
            ],404);
        }else{
            $temp_service = DB::table('services')->where('company_id',"=",$company)->where('id',"=",$service)->get();
            
            if(count($temp_service)==0){
                return response()->json([
                    "message" => "Service with the given ID don't exist"
                ],404);
            }
            return response()->json([
                "data" => $temp_service
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request
     */
    public function update($company, $service, Request $request)
    {
        $temp = Company::find($company);
        json_decode($request->getContent());

        if (json_last_error() != JSON_ERROR_NONE) {
            // There was an error
            return response()->json([
                "message" => "Bad json"
            ],400);
        }

        if(is_null($temp)){
            return response()->json([
                "message" => "Data not found (company)"
            ],404);
        }else{
            $request->validate([
                'name' => ['sometimes','required','string'],
                'description' => ['sometimes','required', 'string'],
                'price' => ['sometimes','required','numeric', 'between:0.00,9999.99']
            ]);
            $temp_service = DB::table('services')->where('company_id',"=",$company)->where('id',"=",$service)->get();
            // $temp_service = Service::find($service);
            
            if(count($temp_service)==0){
                return response()->json([
                    "message" => "Company don't have service with particular ID"
                ],404);
            }

            $service_update = Service::find($service);

            $service_update->update($request->all());

            return response()->json([
                "data" => $service_update
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request
     */
    public function destroy($company, $service, Request $request)
    {
        $temp_service = DB::table('services')->where('company_id',"=",$company)->where('id',"=",$service)->get();
        
        if(count($temp_service)==0){
            return response()->json([
                "message" => "Company don't have service with particular ID"
            ],404);
        }

        $service_update = Service::find($service);
        $service_update->forceDelete();

        return response()->json([
            "data" => $service_update
        ]);
    }
}
