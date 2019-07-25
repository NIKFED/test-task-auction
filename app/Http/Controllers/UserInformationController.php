<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInformationController extends Controller
{
    public function getBalance(Request $request)
    {
        $CurrentUser = User::find($request->id);

        $balance_data = $CurrentUser->balance;

        return $balance_data;
    }

    public function getName(Request $request)
    {
        $CurrentUser = User::find($request->id);

        $name_data = $CurrentUser->name;

        return $name_data;
    }

    public function checkAdmin(Request $request)
    {
        $CurrentUser = User::find($request->id);

        $check_admin_data = $CurrentUser->is_admin;

        return $check_admin_data;
    }

    public function writingBalance(Request $request)
    {
        $newBalance = $request->get('balance');

        DB::table('users')
            ->where('id', $request->get('user_id'))
            ->update([
                'balance' => $newBalance,
            ]);

    }
}
