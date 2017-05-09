<?php

namespace App\Http\Controllers;


use App\Models\Company;

use App\Models\Fatcha\Crypt\CryptId;

use App\Models\Project;
use App\Models\ProjectCategory;
use Auth;
use Mail;


use Illuminate\Http\Request;







class ProjectController extends Controller{
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }

    public function edit(Request $request, $company_key,$cid = null) {

        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsMember(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }
        $project = new Project;
        if($cid != null){
            $project = Project::find(CryptId::unCryptHashToId($cid));

        }

        if($request->isMethod("POST")){
            $project->name = $request->input('name');
            $project->job_number = $request->input('job_number');
            $project->company_id = $company->id;
            $project->end_expectation = $request->input('end_expectation');
            $project->user_pm_id = $request->input('user_pm_id');
            $project->color = $request->input('color');
            $project->category_id = $request->input('category_id');
            $project->save();
            return redirect(route('company_home',['company_key'=>$company->key]));
            //return redirect(route('company_project_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($project->id)]));
        }

        $companyUsers = [];
        foreach ($company->users as $users){
            $companyUsers[$users->id] = $users->name;
        }

        $categories = [];
        foreach ($company->projectsCategories as $category){
            $categories[$category->id] = $category->name;
        }


        return view('projects.form',[
            'company' => $company,
            'project' => $project,
            'users' => $companyUsers,
            'categories' => $categories,
        ]);
    }

    public function editCategory(Request $request, $company_key,$cid = null) {
        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsMember(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }

        $category = new ProjectCategory();
        if($cid != null){
            $category = ProjectCategory::find(CryptId::unCryptHashToId($cid));

        }

        if($request->isMethod("POST")){
            $category->name = $request->input('name');
            $category->company_id = $company->id;

            $category->save();
            return redirect(route('company_home',['company_key'=>$company->key]));
        }




        return view('projects.form_cat',[
            'company' => $company,
            'category' => $category,
        ]);
    }



}
