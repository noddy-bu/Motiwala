<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index() {
        $author = User::whereNotIn('role_id', ['0'])
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->orderBy('users.id', 'desc')
        ->get(['users.id', 'users.fullname', 'users.email', 'users.phone', 'users.status', 'users.created_at', 'roles.name as role_name']);
        return view('backend.pages.author.index', compact('author'));
    }

    public function add() {
        return view('backend.pages.author.add');
    }  
    
    public function create(Request $request) {

        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'notification' => $validator->errors()->all()
            ], 200);
        } 

        $author = User::create([
            'fullname' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' =>  $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'role_id' => $request->input('role_id'),
        ]);

        $response = [
            'status' => true,
            'notification' => 'User added successfully!',
        ];
        
        return response()->json($response);
    }     

    public function edit($id) {
        $author = User::find($id);
        return view('backend.pages.author.edit', compact('author'));
    }  
    
    public function delete($id) {
        
        $author = User::find($id);
        if (!$author) {
            $response = [
                'status' => false,
                'notification' => 'Record not found.!',
            ];
            return response()->json($response);
        }
        $author->delete();

        $response = [
            'status' => true,
            'notification' => 'User Deleted successfully!',
        ];

        return response()->json($response);
    }  
    
    public function status($id, $status) { 
        $author = User::find($id);
        $author->status = $status;
        $author->save();
    
        return redirect(route('author.index'))->with('success', 'Status Change successfully!');
    }  
    
    public function update(Request $request) {

        // Validate form data
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|unique:Users,email,'. $request->input('id'),
            'phone' => 'required|unique:users,phone,'. $request->input('id'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'notification' => $validator->errors()->all()
            ], 200);
        } 

        $id = $request->input('id');
        $author = User::find($id);

        $author->fullname = $request->input('fullname');
        $author->email = $request->input('email');
        $author->phone = $request->input('phone');
        $author->role_id = $request->input('role_id');

        if($request->has('password') && !empty($request->input('password')) && $request->input('password') != ""){
            $author->password = bcrypt($request->input('password'));
        }
    
        $author->save();

        $response = [
            'status' => true,
            'notification' => 'User Update successfully!',
        ];

        return response()->json($response);
    }   
}
