<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeesValidation;
use App\Models\Company;
use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
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
        $data['employee'] = Employe::orderBy('id', 'desc')->paginate(10);
        $data['company'] = Company::all();

        return view('employee', $data);
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
    public function store(EmployeesValidation $request)
    {
        $payloads = $request->all();
        $employee = Employe::updateOrCreate(['id' => $request->id], $payloads);

        return response()->json(['code' => 200, 'message' => 'Employe Created successfully', 'data' => $employee], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Employe::find($id);

        return response()->json($data);
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
    public function update(EmployeesValidation $request, $id)
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
        $post = Employe::find($id)->delete();

        return Response::json($post);
    }
}
