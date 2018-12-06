<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Companies;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\File as FileResource;
use Intervention\Image\ImageManagerStatic as Image;
use App\FileUploads;


class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Companies::orderBy('created_at','desc')->paginate(5);
        // returnn collection of companies as a resource
        return  CompanyResource::collection($companies);
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
        //print_r($request->input('image'));
        $company = $request->isMethod('put') ? Companies::findOrFail($request->company_id) : new Companies;
        $company->id = $request->input('company_id');
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        //$company->logo = $request->input('logo');




        if($request->input('image') && $request->input('image') != $request->input('logo')){
            $image = $request->input('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

            Image::make($request->input('image'))->save(public_path('logo'.DIRECTORY_SEPARATOR ).$name);

            $image= new FileUploads();
            $image->image_name = $name;
            $image->save();

            $company->logo = 'logo'.DIRECTORY_SEPARATOR .$name;
        } else {
            if($company->logo != Null || $company->logo != ''){
                $company->logo = $company->logo;
            } else {
                $company->logo = 'logo'.DIRECTORY_SEPARATOR .'tmp.jpg';
            }
        }


        if($company->save()){
            return  new CompanyResource($company);
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
        //get a single company
        $company = Companies::findOrFail($id);
        // return a single company as resource
        return new CompanyResource($company);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //destroy a single company
        $company = Companies::findOrFail($id);
        if($company->delete()){
            return new CompanyResource($company);
        }
    }
}
