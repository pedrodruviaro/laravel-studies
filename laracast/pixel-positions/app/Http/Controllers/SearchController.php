<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke()
    {
       $q = request('q');

       $jobs = Job::with(['tags', 'employer'])->where('title', 'LIKE', '%'.$q.'%')->get();

       return view('results', ['q' => $q, 'jobs' => $jobs]);
    }
}
