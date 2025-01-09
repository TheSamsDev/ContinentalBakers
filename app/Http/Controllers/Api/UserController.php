<?php

namespace App\Http\Controllers\Api;

use App\helper\S3Helper;
use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

//        if(!$request->user()->hasPermissionTo("user-list")){
//            return apiResponse('fail',"Permission denied",['user not allowed to list user'],405);
//        }
        return User::findOrFail($request->user()->id);
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
        //

    
        
        $validated = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'role' => 'required|exists:roles,name',
        ]);

        if($validated->fails()){
           return ApiRes::validationError($validated);
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole(ucfirst($request->input('role')));

        return ApiRes::success("User created successfully",200,[$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      
        
        $validated = Validator::make($request->all(),[
            'name' => '',
            'email' => 'email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'role_id' => 'exists:roles,id',
        ]);
        if($validated->fails()){
             return ApiRes::validationError($validated);
        }

        return 'hello';


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //

        

//        $user->removeRole('writer');
        $validated = Validator::make([
            'id' => $id
        ],[
            'id' => 'required|exists:users,id',
        ]);
        if($validated->fails()){
            ApiRes::validationError($validated);
        }
      
        
        $user = User::find($id)->delete();
//        $user = User::with('roles')->where('id',$id)->first();
//
//        return $user->roles[0]->pivot;
//        $user->delete();
        return ApiRes::success("Successfully deleted",200,[$user]);



    }


    /**
     * Login method to login via api or gerenrate api authentication token
     * @param Request $request
     * @return array
     */
    public function login(Request $request){
        $validated = Validator::make($request->all(),[
            'email' => 'required|exists:users,email',
            'password' => 'required|max:20|min:8',
        ]);
        if($validated->fails()){
            return ApiRes::validationError($validated);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken("Login token");
            // $user = User::with('roles')->where('id',$user->id)->first();
            $user->token = $token->plainTextToken;

           return ApiRes::success("User Token has been created successfully",200,[$user]);
        }


        return ApiRes::fail("Invalid email or password",401,["Invalid email or password"]);


    }


    public function logout(Request $request){

        User::find($request->user()->id)->tokens()->delete();
        $request->user()->update([
            'device_token' => null,
        ]);
        return apiResponse('success','logout successfully',[],200);
    }
    public function getAllUsers(Request $request){

        if(!$request->user()->hasPermissionTo("user-list")){
            return apiResponse('fail',"Permission denied",['user not allowed to list users'],405);
        }

        return apiResponse("success","user fetched successfully!",User::get()->toArray());

    }


    public function getMyPermissions(Request $request){

    }


    public function changeNumber(Request $request){

        Session::put('selected_phone_number',$request->numberSelected);

        // dd(session()->get("selected_phone_number"));
        return redirect()->back();
    }

    

}
