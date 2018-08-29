<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Term extends Model {
	protected $table = 'terms';
	protected $primaryKey = 'term_id';

	protected $appends = ['term_display'];

	/**
	 * Replaces the dash in the term name and replaces it with a space.
	 *
	 * @return string
	 */
	public function getTermDisplayAttribute(){
		return str_replace("-", " ", $this->term);
	}

	/**
	 * Select first semester that ends soonest after today. If the next term is
	 * Fall and its start is less than or equal to three weeks away then return
	 * the Fall term instead.
	 *
	 * @return Term
	 */
	public function scopeCurrent($query) {
		$terms = $query->nowAndNext(1)->get();
		$current = $terms->first();
		$next = $terms->last();

		// check to see if we should swap to the next term
		$today = Carbon::today();
		$nextStart = Carbon::parse($next->begin_date);

		$switchWeeks = config('app.weeks_before_next_semester_switch');

		// is the next term start date within three weeks away?
		$diff = $today->diffInWeeks($nextStart, false);
		if($diff >= 0 && $diff <= $switchWeeks) {
			// return the next semester
			return $next;
		}

		return $current;
	}

	public function scopeFind($term_id)
	{
		return Term::pastAndNow()->where('term_id', '=', $term_id);
	}

	/**
	 * Returns the next ${take} term(s) along with the current term. If you
	 * provide a ${take} value of 2 then you will get 3 terms back, for example.
	 *
	 * @param integer $take The number of additional terms to retrieve
	 * @return Collection:Term
	 */
	public function scopeNowAndNext($query, $take=2) {
		return $query->where('end_date', '>', Carbon::now())
			->orderBy('end_date')->take($take + 1);
	}

	/**
	 * Returns the next ${take} term(s) along with the current term. If you
	 * provide a ${take} value of 2 then you will get 3 terms back, for example.
	 *
	 * @param integer $take The number of additional terms to retrieve
	 * @return Collection:Term
	 */
	//$take=3 needs to be changed to $take=2, when Fall 2016 hits because Winter term stops being used.
	public function scopePastAndNow($query, $take=2) {
		return $query->where('begin_date', '<', Carbon::now())
			->orderBy('end_date', 'DESC')->take($take + 1);
	}

    /**
     * Returns whether this is the Summer term.
     *
     * @return boolean
     */
	public function isSummer() {
	    return ends_with($this->term_id, '5');
    }

	/**
	 * Returns whether this is the Fall term.
	 *
	 * @return boolean
	 */
	public function isFall() {
		return ends_with($this->term_id, '7');
	}

    /**
     * Returns a Collection of terms to be used for drop-down selections.
     *
     * The collection has two keys:
     * "current" - this is the instance of the current Term
     * "terms" - this is the Collection of terms to display
     *
     * @return Collection
     */
	public static function termsCollection() {
        $switchWeeks = config('app.weeks_before_next_semester_switch');

        // grab past terms plus the current term to populate the drop-downs
        // on the profile page for Office Hours and Classes
        $terms = Term::pastAndNow()->get();
        $grabNextTerm = Term::nowAndNext(1)->get();

        $term = $terms->first(); // current term

        // grab the FIRST element off the collection; when pop() was used
        // previously it would return the LAST element
        $nextTerm = $grabNextTerm->first();

        // if for some reason the next term renders to the current term, use
        // the LAST term in the collection
        if($nextTerm->term_id == $term->term_id) {
            $nextTerm = $grabNextTerm->last();
        }

        //Add the the next Term to the beginning of the collection
        //This must be done after $term = $term->first() because
        //it will grab the next term otherwise
        if(Carbon::now()->addWeeks($switchWeeks) > $nextTerm->begin_date){
            $terms->prepend($nextTerm);

            // re-assign the term that will be used for display
            $term = $nextTerm;
        }
        else if($term->isSummer()) {
            // if the current term is Summer, prepend Fall onto the Collection
            $terms->prepend($nextTerm);
        }

        // limit the number of terms that are displayed
        $terms = $terms->take(3);

        return collect(['current' => $term, 'terms' => $terms]);
    }
}
