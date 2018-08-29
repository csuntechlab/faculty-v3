<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Term;

class TermController extends Controller
{
	/**
	 * Returns both the set of terms available for drop-down selection as well
	 * as the current term instance.
	 *
	 * @return JSON
	 */
	public function getTerms() {
		return Term::termsCollection();
	}
}