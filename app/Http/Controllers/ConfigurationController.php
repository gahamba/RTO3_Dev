<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;
use App\System;
use App\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function show(Configuration $configuration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function edit(Configuration $configuration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Configuration $configuration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Configuration $configuration)
    {
        //
    }

    /**
     * Create new config
     */
    public function postCreateConfig(Request $request){

        $times = $request->get('times');
        $company_id = auth::user()->company_id;
        $this_company = Configuration::where('companyId', '=', $company_id)->first();
        if($this_company){
            $this_company->times = $times;
            $this_company->createdBy = auth::user()->id;

            if($this_company->save()){
                $global = 0;
                $message = "Successfuly updated configuration";
            }
            else{
                $global = 1;
                $message = "Sorry, we are unable to update configuration at this time";
            }

        }
        else{
            $this_company = Configuration::create(array(
                'companyId'     =>  $company_id,
                'times'         =>  $times,
                'createBBy'     =>  auth::user()->id,
            ));
            if($this_company){
                $global = 0;
                $message = "Successfuly added configuration";
            }
            else{
                $global = 1;
                $message = "Sorry, we are unable to add configuration at this time";
            }
        }

        return redirect()->back()
                        ->with('global', $global)
                        ->with('message', $message);
    }
}
