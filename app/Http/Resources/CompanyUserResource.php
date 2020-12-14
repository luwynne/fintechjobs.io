<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\CompanyUserHelper;
use App\User;

class CompanyUserResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){

        if ($this->resource == null){
            return null;
        }

        $user = $this->resource;
        $companyUserHelper = new CompanyUserHelper();
        $canAddUser = $companyUserHelper->getCompanyUsers();
        $company_users = User::where('company_id', $user->company_id)->get();

        return [
            'canAddUser' => $canAddUser,
            'company_users' => $company_users
        ];

    }
}
