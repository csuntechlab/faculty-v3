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
    public function faculty(Request $request, $id) {
        $department = Department::with([
            'contact',
            'faculty' => function($q) {
                $q->whereNotDeceased()
                    ->whereActive()
                    ->orderBy('last_name', 'ASC')
                    ->orderBy('first_name', 'ASC');
            },
        ])
        ->findOrFail($id);

        // remove any potential duplicates of the faculty members based upon
        // the user ID
        $department->faculty = $department->faculty->unique(function($user) {
            return $user->user_id;
        });

        // remove the people collection and turn it into its own variable
        // for iteration consistency on the search results page
        $people = paginateData($request, $department->faculty);
        unset($department->faculty);

        // set the path for the pages
        $people->withPath(route('departments.faculty', ['id' => $id]));

        // these two variables tell the search results page how to display
        // the given information
        $type = 'department_faculty';
        $title = $department->name;
        
        return view('pages.search-results', compact('type', 'title', 'department', 'people'));
    }
}
