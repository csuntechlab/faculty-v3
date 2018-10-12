<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\User;

class DepartmentController extends Controller
{
    /**
     * Displays the set of all available academic departments.
     *
     * @return View
     */
    public function all() {
        $departments = Department::orderBy('name', 'ASC')
            ->get();

        return view('pages.departments', compact('departments'));
    }
}
