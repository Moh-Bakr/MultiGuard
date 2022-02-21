<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function login()
    {
        if (View::exists('admin.auth.login')) {
            return view('admin.auth.login');
        }
        abort(Response::HTTP_NOT_FOUND);
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->except(['_token']);

        if ($this->isAdminActive($request->email)) {
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect(RouteServiceProvider::Admin);
            }
            return redirect()->action([
                AdminController::class,
                'login'
            ])->with('message', 'Error!');
        }
        return redirect()->action([
            AdminController::class,
            'login'
        ])->with('message', 'You are not an Admin!');
    }


    function isAdminActive($email): bool
    {
        $Admin = Admin::whereEmail($email)->IsActive()->exists();

        if ($Admin) {
            return true;
        }
        return false;
    }

}
