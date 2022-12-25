<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function show($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
            'message'=>'User Not Found.'
            ], 404);
        }
        else{
            return response()->json([
                'user'=>$user
            ],200);
        }
    }
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = User::select('id', 'name', 'email')->get();
    //         return Datatables::class::of($data)->addIndexColumn()
    //         ->addColumn('action', function($data) {
    //         $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';

    //         $button .= ' <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
    //         return $button;
    // })
    //     ->make(true);
    //     }
    //     return view('layouts.users');
    // }

    // public function store(Request $request)
    // {
    //     $rules = array(
    //     'name' => 'required',
    //     'email' => 'required',
    //     'password' => 'required'
    //     );
    //     $error = Validator::class::make($request->all(), $rules);
    //     if ($error->fails()) {
    //         return response ()->json(['errors' =>$error->errors()->all()]);
    //     }
    //     $pass = $request->password;
    //     $postpass= Hash::make($pass);
    //     $formData= array(
    //         'name'=> $request->name,
    //         'email' => $request ->email,
    //         'password' =>$postpass
    //     );
    //     User::create($formData);
    //     return response ()->json (['success' => 'Data Added successfully. ']);
    // }
    // public function edit($id){
    //     if(request()->ajax())
    //     {
    //         $data=User::findOrFail($id);
    //         return response()->json(['result'=> $data]);
    //     }
    // }
    // public function update(Request $request)
    // {

    //     $rules = array(
    //     'name' => 'required',
    //     'email' => 'required'
    //     );
    //     $error = Validator::class::make($request->all(), $rules);
    //     if ($error->fails()) {
    //         return response ()->json(['errors' =>$error->errors()->all()]);
    //     }
    //     $formData=array(
    //     'name'=>$request->name,
    //     'email' =>$request->email
    //     );
    //     User::whereId($request->hidden_id)->update($formData);

    //     return response ()->json (['success' => 'Data is successfully Updated. ']);
    // }
    // public function destroy($id){
    //     $data=User::findOrFail($id);
    //     $data->delete();
    // }
}
