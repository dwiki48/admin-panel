<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesValidation;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['company'] = Company::orderBy('id', 'desc')->paginate(10);

        return view('company', $data);
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
    public function store(CompaniesValidation $request)
    {
        $payloads = $request->all();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file_name = time() . "_" . $file->getClientOriginalName();

            $file->move('logo', $file_name);
            $payloads['logo'] = $file_name;
        }
        $company = Company::updateOrCreate(['id' => $request->id], $payloads);

        return response()->json(['code' => 200, 'message' => 'Company Created successfully', 'data' => $company], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Company::find($id);

        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Company::find($id);

        return Response::json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompaniesValidation $request, $id)
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
        $post = Company::find($id)->delete();

        return Response::json($post);
    }
}
