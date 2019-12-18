<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Index fetches all the companies from the database and sends to the company view
     * @return landing page for companies
     */
    public function landing(){
        $companies = Company::all();
        return view('company')
                ->with('companies', $companies);
    }

    /**
     *Display listing of companies
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $companies = Company::orderBy('id', 'DESC')->get();
        $comps = array();
        foreach($companies as $company){
            array_push($comps,
                array(
                    'id'            =>  $company->id,
                    'name'          =>  $company->name,
                    'description'   =>  $company->description,
                    'created_by'    =>  User::find($company->created_by)->name,

                )
            );
        }

        return response()->json($comps);
    }

    /**
     *
     */
    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $name = $request->get('name');
        $description = $request->get('description');
        $this_company = Company::where('name', '=', $name)->first();
        $msg = 'Sorry, we cannot add company at this time, please try again';
        if($this_company){
            $msg = 'Company already exists';
        }
        else{
            $company = new Company([
                'name' => $name,
                'description' => $description,
                'created_by' => auth::user()->id
            ]);
            $company->save();
            $msg = 'Successfully added';
        }

        return response()->json($msg);
    }

    /**
     *
     */
    public function show(){

    }

    /**
     *
     */
    public function edit(){

    }

    /**
     * Update companies table.
     */
    public function update(Request $request){

        $company = Company::find($request->get('id'));
        $company->name = $request->get('name');
        $company->description = $request->get('description');
        $company->created_by = auth::user()->id;
        $company->save();

        return response()->json('Successfully Updated company');

    }

    /**
     *
     */
    public function destroy($id){
        $company = Company::find($id);
        $company->delete();

        return response()->json('Successfully Deleted');
    }
}
