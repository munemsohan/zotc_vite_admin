<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Role;
use App\Models\RoleTranslation;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ApiController extends Controller
{
    public function index()
    {
        return view('api.index');
    }
}
