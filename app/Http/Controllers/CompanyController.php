<?php

namespace App\Http\Controllers;

use App\{
    Company,
    User,
    Payment,
    CompanySector,
    CompanyDescription,
    CompanyLogo,
    CompanyVideo,
    CompanySocialMedia,
    Country,
    EducationInstitute
};

use Illuminate\Http\Request;
use App\Helpers\CompanyUserHelper;
use App\Http\Requests\{
    CreateCompanyRequest,
    InviteUserRequest,
    UpdateCompanyRequest,
    SaveCompanyAssetsRequest,
    UserRoleRequest
};

use App\Http\Resources\{
    CompanyResource,
    CompanyUserResource
};

use Auth;
use Mail;
use Carbon\Carbon;
use Image;
use File;

use App\Services\CompanyService;


class CompanyController extends Controller{


    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.app');
    }


    public function registerCompany(){
        $sectors = CompanySector::whereNotIn('id',[21,22])->get();
        $countries = Country::where('name', '!=', 'Other')->orderBy('name')->get();
        return view('auth.companyRegister', compact(['sectors', 'countries']));
    }

    public function store(CreateCompanyRequest $request){

        $company = new Company();
        $company->name = $request->input('companyname');
        $company->sector_id = $request->input('companysector');
        $company->address = $request->input('companyaddress');
        $company->phone = $request->input('companyphone');
        $company->website = CompanyService::websiteUrlCleansing($request->input('companywebsite'));
        $company->representative_id = Auth::user()->id;
        $company->save();

        User::where('id', $company->representative_id)->update(array('company_id' => $company->id));

        CompanyService::createBasePackage($company->id);
        CompanyService::createCompanyPlaceHolders($company);

        if($request->input('companysector') == 22){
            $institute = new EducationInstitute();
            $institute->name = $company->name;
            $institute->country_id = $request->input('country');
            $institute->company_id = $company->id;
            $institute->url = $company->website;
            $institute->contact_email = Auth::user()->email;
            $institute->save();
        }
        
        return redirect('/admin/home');
    }

    public function companyUser(){
        return response()->json(new CompanyUserResource(Auth::user()), 200);
    }

    public function inviteNewUser(InviteUserRequest $request){

        $companyUsers = User::where('company_id', Auth::user()->company_id)->get();

        $email = $request->input('email');
        $company_id = Auth::user()->company_id;
        $data = array(
            'email' => $email,
            'company_id' => $company_id,
            'newsletter' => false
        );

        Mail::send('mails.inviteUser', $data, function($message) use ($email){
            $message->to($email, $email)->subject('Invitation | Fintechjobs.io');
            $message->from('info@fintechjobs.io','Fintechjobs.io');
        });

        return response()->json(['message' => 'An invitation has been sent to '.$email.'!' ,200]);

    }


    public function getCompanyInfo(){
        $company = Company::findOrFail(Auth::user()->company->id);
        return response()->json(new CompanyResource($company), 200);
    }


    public function updateCompany(UpdateCompanyRequest $request, $company_id){
        
        $company = Company::findOrFail($company_id);
        $company->name = $request->input('name');

        if(!$company->isEducationInstitute() ){
            $company->sector_id = $request->input('sector_id');
        }
        
        $company->address = $request->input('address');
        $company->phone = $request->input('phone');
        $company->website = CompanyService::websiteUrlCleansing($request->input('website'));

        $company->save();
        $company->refresh();

        $company->facebook->url = str_replace("https://", "", $request->input('facebook.url'));
        $company->facebook->save();

        $company->linkedin->url = str_replace("https://", "", $request->input('linkedin.url'));
        $company->linkedin->save();

        $company->twitter->url = str_replace("https://", "", $request->input('twitter.url'));
        $company->twitter->save();
        
        if($company->description){
            $company->description->content = $request->input('description.content');
        }else{
            $description = new CompanyDescription();
            $description->company_id = $company->id;
            $description->content = $request->input('description.content');
        }
        $company->description->save();

        if($company->isEducationInstitute() ){
            $company->education_institute->name = $company->name;
            $company->education_institute->url = 'https://'.$company->website;
            $company->education_institute->save();
        }
        
        return response()->json($company);
    }


    public function changeUserRole(UserRoleRequest $request, $user_id){
        $user = User::find($user_id);
        if($user){
            $user->role = $request->input('role');
            $user->save();
            return response()->json(200);
        }else{
            abort(401); 
        }
    }


    public function deleteCompanyUser(UserRoleRequest $request, $user_id){
        $user = User::find($user_id);
        if($user){
            $user->delete();
            return response()->json(200);
        }else{
            return response()->json(401);
        }
    }

    public function getLoggedUser(){
        return Auth::user();
    }

    public function getCompanyLogo(){
        return Auth::user()->company->logo;
    }

    public function getCompanyVimeoVideo(){
        return Auth::user()->company->vimeo_video;
    }

    public function getCompanyYoutubeVideo(){
        return Auth::user()->company->youtube_video;
    }

    public function saveCompanyLogo(SaveCompanyAssetsRequest $request){

        $company = Auth::user()->company;

        if($request->get('image')){

            if($company->logo){
                $destinationpath = public_path('admin/img/logos/');
                $file_path = $destinationpath.$company->logo->file_name;
                unlink($file_path);
                $company->logo->delete();
            }
            $image = $request->get('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('admin/img/logos/').$name);

            $image= new CompanyLogo();
            $image->company_id = $company->id;
            $image->file_name = $name;
            $image->save();

            if($company->isEducationInstitute()){
                if($company->education_institute->logo_name !== null){
                    $institute_destination_path = public_path('images/sample/institutes/');
                    $institute_file_path = $institute_destination_path.$company->education_institute->logo_name;
                    unlink($institute_file_path);
                }
                Image::make($request->get('image'))->save(public_path('images/sample/institutes/').$name);
                $company->education_institute->logo_name = $name;
                $company->education_institute->url = 'https://'.$company->website;
                $company->education_institute->save();
            }

            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        }

        return response()->json(['error' => 'No image provided'], 422);

    }

    public function saveCompanyVimeoVideo(SaveCompanyAssetsRequest $request){

        $company = Auth::user()->company;

        if($company->vimeo_video){
            $video = $company->vimeo_video;
        }else{
            $video = new CompanyVideo();
            $video->company_id = $company->id;
            $video->type_id = 1;
        }
        $video->external_id = $request->get('external_id');
        $video->save();
        return response()->json(['success' => 'You have successfully uploaded an image'], 200);
    }

}
