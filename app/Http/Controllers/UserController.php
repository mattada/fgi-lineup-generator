<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    public function selectPlan(Request $request)
    {
        $data = $request->all();

        if (Auth::User()->cointent_id == $data['uid']) {

            $plan = Plan::where('cointent_id', $data['planId'])->first();

            if ($plan) {

                Auth::User()->update(['plan_id' => $plan->id]);

                return $this->callback(function() {

                    return $this->returnSuccessArray();

                }, function() {

                    return $this->returnSuccessArray();

                }, $request);

            }

        }

        return $this->callback(function() {

            return $this->returnErrorArray();

        }, function() {

            return $this->returnErrorArray();

        }, $request);

    }

}
