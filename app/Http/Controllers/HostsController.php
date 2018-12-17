<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\TableHostAccess;
use App\Http\Resources\TableHostAccess as TableHostResource;

class HostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hosts = TableHostAccess::orderBy('created_at','desc')->paginate(5);
        // returnn collection of hosts as a resource
        return  TableHostResource::collection($hosts);
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

        $host = $request->isMethod('put') ? TableHostAccess::findOrFail($request->host_id) : new TableHostAccess;
        $host->id = $request->input('host_id');
        $host->main_name = $request->input('main_name');
        $host->main_name_link = $request->input('main_name_link');
        $host->hosting_type = $request->input('hosting_type');
        $host->hosting_name = $request->input('hosting_name');
        $host->hosting_link = $request->input('hosting_link');
        $host->hosting_login = $request->input('hosting_login');
        $host->hosting_pass = $request->input('hosting_pass');
        $host->comment = $request->input('comment');

        if($host->save()){
            return  new TableHostResource($host);
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
        //get a single host
        $host = TableHostAccess::findOrFail($id);
        // return a single host as resource
        return new TableHostResource($host);
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
        //destroy a single host
        $host = TableHostAccess::findOrFail($id);
        if($host->delete()){
            return new TableHostResource($host);
        }
    }
}