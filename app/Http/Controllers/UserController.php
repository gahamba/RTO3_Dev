<?php

namespace App\Http\Controllers;

use App\Company;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * Index fetches all the companies from the database and sends to the company view
     * @return landing page for companies
     */
    public function landing(){
        $users = User::where('company_id', '=', auth::user()->company_id)->get();
        return view('user')
            ->with('users', $users);
    }

    /**
     * Index fetches all the companies from the database and sends to the company view
     * @return initial landing page for companies
     */
    public function initial_landing(){
        $users = User::where('company_id', '=', auth::user()->company_id)->get();
        return view('initial_user')
            ->with('users', $users);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('company_id', '=', auth::user()->company_id)
                    ->orWhere('parent_user', '=', auth::user()->id)->get();

        return response()->json($users);

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
        try{
            $name = $request->get('name');
            $email = $request->get('email');
            $user_type = $request->get('user_type');
            $userExist = User::where('email', '=', $email)->get();
            $msg = 'Sorry, we cannot add user at this time, please try again';
            if(count($userExist) < 1 && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $user = new User([
                    'name'          =>  $name,
                    'email'         =>  $email,
                    'company_id'    =>  auth::user()->company_id,
                    'user_type'     =>  $user_type,
                    'parent_user'   =>  auth::user()->id,
                    'password'      =>  Hash::make('password'),
                ]);
                $user->notify(new VerifyEmail($user));
                if($user->save()){

                    $msg = 'Successfully added';
                }
            }
            else{
                $msg = 'Sorry, email already exists or in wrong format';
            }


            return response()->json($msg);

        }
        catch(Exception $ex){
            $msg = $ex;
            return response()->json($msg);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->get('name');
        $phone = $request->get('phone');
        $user_type = $request->get('user_type');

        $user = User::find($id);
        $user->name = $name;
        $user->phone = $phone;
        $user->user_type = $user_type;
        if($user->save()){
            $msg = "Successfully updated record";
        }
       else{
            $msg = "Sorry, there has been an issue updating record at this time, please retry later";
        }

        return response()->json($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $email_value
     * @return \Illuminate\Http\JsonResponse
     * check if email address is valid
     */
    public function checkEmail($email_value){

        $resp = false;
        $user = User::where('email', '=', $email_value)->get();
        if(count($user) < 1 && filter_var($email_value, FILTER_VALIDATE_EMAIL)){
            //Email already exists, so return false
            $resp = true;
        }



        return response()->json($resp);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Returns the profile page
     */
    public function getProfile(){
        return view('profile');
    }

    /**
     * Saves the modified the profile and returns to page
     */
    public function postProfile(){

        $user = User::find(auth::user()->id);
        $fullname = Input::get('fullname');
        $message = Input::get('message');
        $phone = Input::get('phone');
        $user->name = $fullname;
        $user->phone = $phone;
        $user->message = $message;

        $changed = $user->save();
        if($changed){
            $global = 0;
            $message = 'Updated';
        }
        else{
            $global = 1;
            $message = 'Unable to update at this time. please try again later';
        }
        return redirect()->back()
            ->with('global2', $global)
            ->with('message', $message);
    }

    /**
     * Saves the modified the password and returns to page
     */
    public function postPassword(Request $request){

        $request->validate([
            'oldpassword' => ['required', new MatchOldPassword()],
            'newpassword' => ['required'],
            'confirm' => ['same:newpassword'],
        ]);

        $changed = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newpassword)]);

        if($changed){
            $global = 0;
            $message = 'Updated';
        }
        else{
            $global = 1;
            $message = 'Unable to update at this time. please try again later';
        }

        return redirect()->back()
            ->with('global3', $global)
            ->with('message', $message);
    }

}
