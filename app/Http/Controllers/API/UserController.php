<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
        $this->middleware('auth:api');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return User::latest()->paginate(10);
        }
        // $this->authorize('isAdmin');
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:
            255',
            'email' => 'required|email|string|max:
            255|unique:users',
            'password' => 'required|string|min:6
            '
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'role' => $request['role'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password'])
        ]);
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

    public function profile()
    {
        return auth('api')->user();
        // $user = User::findOrFail($id);
        // return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        // $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:
            255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6
            '
        ]);

        if(!empty($request->photo)) {
            $currentPhoto = $user->photo;
            if($request->photo != $currentPhoto) {
                // $name = time().'.'.'jpg';
                $name = time().'.'. explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                // dd($name);
                \Image::make($request->photo)->save(public_path('img/profile/').$name);

                $request->merge(['photo' => $name]);

                $userPhoto = public_path('img/profile/').$currentPhoto;
                if (file_exists($userPhoto)) {
                    @unlink($userPhoto);
                }

            }
        }

         if(!empty($request->password)) {
             $request->merge(['password' => Hash::make($request['password'])]);
         }

         $user->update($request->all());
        return ['Message' => 'Success'];
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6'
        ]);

        $user->update($request->all());

        return ['User\'s information updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);

        $user->delete();
    }

    public function findUser() {

        if($search = \Request::get('q')) {
            $user = User::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('role', 'LIKE', "%$search%");
            })->paginate(5);

        } else {
            $user = User::latest()->paginate(10);
        }

        return $user;   
    }
}
