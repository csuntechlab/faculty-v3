<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class WelcomeController extends Controller
{
    /**
     * Displays the set of faculty that match a given search query.
     *
     * @return View
     */
    public function welcome(Request $request) {
        $query = User::with([
            'connections',
            'departments',
        ]);

        // if we have a search query, then let's perform some filtering
        $q = $request->input('q');
        if(!empty($q)) {
            $tokens = explode(' ', $q);

            // tokenize the query and chain in a single where clause delimited with wildcards
            $where = '%';
            foreach($tokens as $token) {
                $where.="{$token}%";
            }
            $query = $query->where(function($q) use ($where) {
                $q->where('display_name', 'LIKE', $where)
                    ->orWhere('common_name', 'LIKE', $where);
            });
        }

        // we want to make sure we only retrieve faculty members that are
        // currently alive and active
        $query = $query->whereFaculty()
            ->whereNotDeceased()
            ->whereActive();

        // ensure we order by last name and then first name
        $query = $query->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC');

        // now just execute the query
        $users = $query->get();

        // remove any potential duplicates of the faculty members based upon
        // the user ID
        $users = $users->unique(function($user) {
            return $user->user_id;
        });

        // remove the people collection and turn it into its own variable
        // for iteration consistency on the search results page
        $people = paginateData($request, $users);

        // these two variables tell the search results page how to display
        // the given information
        if(!empty($q)) {
            $type = 'search_results';
            $title = "Search results: $q";

            // set the path for the pages
            $people->withPath(route('welcome') . "?q=$q");
        }
        else
        {
            $type = 'all_faculty';
            $title = "All Faculty";

            // set the path for the pages
            $people->withPath(route('welcome'));
        }
        
        return view('pages.welcome', compact('type', 'title', 'department', 'people', 'q'));
    }
}
