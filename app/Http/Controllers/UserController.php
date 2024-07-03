<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        $users = User::where('name', 'like', "%{$query}%")->get();
        //$users = User::all();

        return response()->json($users);
    }
}
