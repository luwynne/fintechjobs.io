<?php

namespace App\Http\Controllers;

use App\User;
use App\Helpers\CompanyUserHelper;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNewUserRequest;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller{

    public function __construct() {
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    public function newUserView($company_id){
        $company_id = $company_id;
        return view('auth.new-user')->with(compact('company_id'));
    }


    public function createNewUser(CreateNewUserRequest $request){

        $company_users = User::where('company_id', $request->input('company_id'))->get();

        if($company_users->count() >= 3){
            return redirect()->back()->with('userNotCreated', 'Company users exceeded!');
        }else{
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'company_id' => $request->input('company_id'),
                'role' => 'user'
            ]);
            return redirect('/login');
        }

    }




}
