<?php

namespace App\Http\Controllers;

use App\Device;
use App\Action;
use App\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ActionController extends Controller
{
    public function landing(){
        $actions = Action::where('company_id', '=', auth::user()->company_id)
            ->orderBy('created_at', 'DESC')->get();

        return view('correctiveaction')
            ->with('actions', $actions);
    }
    /**
     * Post CorrectiveAction form and handle request
     *
     */
    public function postCreateCorrectiveAction(){

        $action = Input::get('corrective_action');
        $exist = Action::where('company_id', '=', auth::user()->company_id)
                        ->where('action', '=', $action)->first();

        if($exist){
            $global = 1;
            $message = "Action with exact wordings have been added already";
        }
        else{
            $actn = Action::create(array(
                'company_id' => auth::user()->company_id,
                'action'     => strip_tags($action),
                'created_by' => auth::user()->id,

            ));

            if($actn){
                $global = 0;
                $message = "Successfully added Action";
            }
            else{
                $global = 1;
                $message = "Unable to add at this time";
            }

        }

        return redirect()->back()
            ->with('global', $global)
            ->with('message', $message);
    }

    /**
     * Edit CorrectiveAction post
     *
     */
    public function postUpdateCorrectiveAction(){

        $action_id = Input::get('action_id');

        $corrective_action = Input::get('corrective_action');

        $action = Action::find($action_id);


        $exists = Action::where('_id', '!=', $action_id)
                        ->where('action', '=', $corrective_action)
                        ->where('company_id', '=', $action->company_id)->first();

        if(!$exists){
            $action->action = strip_tags($corrective_action);
            $action->created_by = auth::user()->id;

            if($action->save()){
                $global = 0;
                $message = "Successfully updated Action";
            }
            else{
                $global = 1;
                $message = "Unable to update Action at this time. Please try again later";
            }
        }
        else{
            $global = 1;
            $message = "This action already exists in your organization";
        }



        return redirect()->back()
            ->with('global', $global)
            ->with('message', $message);

    }

    /**
     * Delete CorrectiveAction
     *
     */
    public function postDeleteCorrectiveAction(){

        $action_id = Input::get('system_id');
        $action = Action::find($action_id);

        if($action->delete()){
            $global = 0;
            $message = "Successfully deleted Action-".$action->action;
        }
        else{
            $global = 1;
            $message = "Cannot delete System-".$action->action." at this time, please try again later";
        }


        return redirect()->back()
            ->with('global', $global)
            ->with('message', $message);

    }
}
