<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Term;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Returns the set of classes with syllabi for the individual identified
     * by the URI for either the current or given semester.
     *
     * @param string $uri The URI of the individual
     * @return JSON
     */
    public function getClasses(Request $request, $uri) {
        $user = User::with('classes.syllabi', 'classes.classMeetings')
            ->whereUri($uri)
            ->firstOrFail();

        // we can either use the current term or a specific term from the
        // Request instance
        if($request->filled('term_id')) {
            $term = Term::find($request->input('term_id'));
        }
        else
        {
            $termCollection = Term::termsCollection();
            $term = $termCollection->get('current');
        }

        // reject any classes with a non-numeric designation since we use
        // those for special cases and they're non-academic
        $user->classes = $user->classes->reject(function($class) {
            return !preg_match('/^[0-9]+$/', $class->class_number);
        });

        // filter the classes to the given term and filter the syllabus for
        // each class to the owning User instance; we are also going to generate
        // the relevant bookstore URLs for each class
        $user->classes = $user->classes->filter(function(&$class) use ($term, $user) {
            // filter the syllabi first to the owning User
            $class->syllabi = $class->syllabi->filter(function($syllabus) use ($user) {
                return $syllabus->user_id == $user->user_id;
            })->values();

            // set a singular syllabus attribute and then unset the syllabi
            // attribute
            $class->syllabus = $class->syllabi->first();
            unset($class->syllabi);

            // set a bookstore URL attribute
            $class->bookstore_url = bookstoreUrl(
                $term->term_id,
                $class->subject,
                $class->catalog_number,
                $class->class_number
            );

            // now check the success condition for the class term
            return $class->term_id == $term->term_id;
        });

        return $user->classes->values();
    }

    /**
     * Returns the set of all classes the individual identified by the URI
     * has ever taught at the university.
     *
     * @param string $uri The URI of the individual
     * @return JSON
     */
    public function getClassHistory($uri) {
        $user = User::with('classes')
            ->whereUri($uri)
            ->firstOrFail();

        // reject any classes with a non-numeric designation since we use
        // those for special cases and they're non-academic
        $user->classes = $user->classes->reject(function($class) {
            return !preg_match('/^[0-9]+$/', $class->class_number);
        });

        // add the times_taught and last_taught attributes to each class
        $user->classes = $user->classes->each(function($class) use ($user) {
            $class->times_taught = $user->classes
                ->where('course_id', $class->course_id)
                ->count();
            $class->last_taught = implode(" ", explode("-", $class->term));
        });

        // finally, limit the set of classes to their unique instances based
        // upon course ID since that will be how the timeline is shown
        $user->classes = $user->classes->unique(function($class) {
            return $class->course_id;
        });

        return $user->classes->values();
    }

    /**
     * Returns the metadata for an individual based on a given URI.
     *
     * @param string $uri The URI of the individual
     * @return User
     */
    public function getMetadata($uri) {
        $user = User::with('connections', 'departments', 'degrees')
            ->whereUri($uri)
            ->firstOrFail();

        if($user->primary_connection) {
            $user->primary_connection->pivot->formatted_telephone =
                formatPhoneNumber($user->primary_connection->pivot->telephone);
        }

        return $user;
    }

    /**
     * Returns the set of office hours for the individual identified
     * by the URI for either the current or given semester.
     *
     * @param string $uri The URI of the individual
     * @return JSON
     */
    public function getOfficeHours(Request $request, $uri) {
        // we can either use the current term or a specific term from the
        // Request instance
        if($request->filled('term_id')) {
            $term = Term::find($request->input('term_id'));
        }
        else
        {
            $termCollection = Term::termsCollection();
            $term = $termCollection->get('current');
        }

        $user = User::with([
            'officeHours' => function($q) use ($term) {
                $q->where('term_id', $term->term_id)
                    ->orderBy('meeting_number', 'ASC');
            }
            ])
            ->whereUri($uri)
            ->firstOrFail();

        return $user->officeHours;
    }
}
