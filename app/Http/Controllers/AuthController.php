<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\alert;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if(Auth::attempt($credentials)){
            $user   = Auth::user();
            $token  = $user->createToken('authToken')->plainTextToken;
            
            return ResponseHelper::onSuccess('User Login successful', ['user' => $user, 'token' => $token], 200);

            
        }else{
            return ResponseHelper::onError('Invalid credentials', 401);
        }
    }

    public function register(Request $request)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|max:255',
                'email'     => 'required|string|email|max:255|unique:users',
                'password'  => 'required|string|min:6|confirmed',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verified_at' => now(),
            ]);

            
        } catch (\Throwable $th) {
            return ResponseHelper::onError($th->getMessage(), 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            
                $user = $request->user();
                $user->tokens()->delete();

                return ResponseHelper::onSuccess('Logout Successful', null ,200);

        } catch (\Throwable $th) {
            return ResponseHelper::onError('Error logout!', 401);
        }
    }
    
    public function deleteUser()
    {
      return view('delete');
    }

    
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $user = User::where('email', $request->email)->first();
            
            $user->delete();
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('delete-user')->with('error', 'Error Delete User!');
        }
        return redirect()->route('delete-user')->with('success', 'Success Delete User!');
    }
}
