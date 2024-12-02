<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class APIController extends Controller
{
    
    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                // Authentication passed...
                /** @var \App\Models\User $user */
                $user = auth()->user();
                return response(["error" => false, 'token' => $user->createToken('API')->plainTextToken]);
            } else {
                return response(["error" => "Authentication Failed!"], 400);
            }
        } catch (ValidationException $e) {
            return response(["error" => $e->errors()], 400);
        } catch (\Throwable $th) {
            return response(["error" => $th->getMessage()], 500);
        }
    }
    
    public function customers()
    {
        try {
            $customers = Customer::orderBy('created_at', 'desc')->get();
            return response(["error" => false, 'customers' =>$customers]);
            
        } catch (\Throwable $th) {
            return response(["error" => $th->getMessage()], 500);
        }
    }
    
    public function sales() 
    {
        try {
            $sales = Sale::with('customer')->orderBy('created_at', 'desc')->get();
            return response(["error" => false, 'sales' =>$sales]);
            
        } catch (\Throwable $th) {
            return response(["error" => $th->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->tokens()->delete();
        return response([
            "error" => false,
            'message' => 'User logged out'
        ]);
    }
}
