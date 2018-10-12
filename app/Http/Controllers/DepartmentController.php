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

    /**
     * Displays the set of faculty in a given academic department.
     *
     * @param string $id The ID of the academic department
     * @return View
     */
    public function faculty($id) {
        $department = Department::with([
            'faculty' => function($q) {
                $q->orderBy('display_name', 'ASC');
            },
        ])
        ->findOrFail($id);
        
        return view('pages.search-results', compact('department'));
    }
}
