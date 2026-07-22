<?php

namespace App\Http\Controllers;

use App\Models\PolicyArticle;
use Illuminate\View\View;

class PolicyController extends Controller
{
    public function index(): View
    {
        return view('pages.policies', [
            'policies' => PolicyArticle::query()->publiclyVisible()->orderBy('id')->get(),
            'selectedPolicy' => null,
        ]);
    }

    public function show(PolicyArticle $policy): View
    {
        abort_unless($policy->is_public && in_array($policy->status, ['guidance', 'approved'], true), 404);

        return view('pages.policies', [
            'policies' => PolicyArticle::query()->publiclyVisible()->orderBy('id')->get(),
            'selectedPolicy' => $policy,
        ]);
    }
}
