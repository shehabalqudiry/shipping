<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use GeneralTrait;
    public function get_register()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        // return $request->all();
        $rules = [
            'name'      => 'required|string|min:8|max:30|unique:users,name',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'phone'     => 'required|numeric|unique:users,phone',
            'password'  => 'required|string|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'account_number'=> $this->generateAccountNumber(),
                'password'      => Hash::make($request->password),
            ]);
            // return $request->all();
            $credentials = request()->only(['email','password']);
            auth()->attempt($credentials, true);

            NotificationController::NewUserRegisteredNotification([
                'user_id'   => $user->id,
                'user_name' => $user->name,
                'link'      => route('admin.users.show', $user->id),
            ]);
            return redirect()->route('front.user.dashboard');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function get_login()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'password'  => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());
        try {
            $type = $request->type;
            // $user = User::whereIn($type, [$request->email, $request->phone, $request->name])->first();
            // if ($user && $user->status == 0) {
            //     return redirect()->route('front.confirmAccount.getForm')->with('error', __('This account does not have an active subscription.'));
            // }
            // $credentials = request()->only(['phone', 'password']);
            // dd(auth('team')->attempt($credentials, true));
            if ($type == 'phone') {
                $credentials = request()->only(['phone', 'password']);
                if(auth()->attempt($credentials, true) or auth('team')->attempt($credentials, true)){
                    return redirect()->route('front.user.dashboard');
                }
            } elseif ($type == 'email') {
                $credentials = request()->only(['email', 'password']);
                if(auth()->attempt($credentials, true) or auth('team')->attempt($credentials, true)){
                    return redirect()->route('front.user.dashboard');
                }
            } elseif ($type == 'name') {
                $credentials = request()->only(['name', 'password']);
                if(auth()->attempt($credentials, true) or auth('team')->attempt($credentials, true)){
                    return redirect()->route('front.user.dashboard');
                }
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return back()->with('error', $e->getMessage());
        }
    }


    public function code()
    {
        return view('pages.user.account.active');
    }


    public function check_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $user = User::where(['email' => $request->email, 'codeVerfiy' => $request->code])->first();

        if (!$user) {
            return back()->with('error', __('validation-inline.enum') . ' ' . __('Code'));
        }

        $user->update(['status' => 1]);

        return redirect()->route('front.get_login')->with('success', __('The action ran successfully!'));
    }
}
