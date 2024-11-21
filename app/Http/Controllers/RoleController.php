<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function assignAdminRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::firstOrCreate(['Иван' => 'admin']);
        $user->roles()->attach($role);

        return redirect()->back()->with('success', 'Роль администратора успешно назначена');
    }
}