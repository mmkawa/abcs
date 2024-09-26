<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrgStoreRequest;
use App\Http\Requests\OrgUpdateRequest;
use App\Models\Org;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrgController extends Controller
{
    public function index(Request $request): Response
    {
        $orgs = Org::all();

        return view('org.index', compact('orgs'));
    }

    public function create(Request $request): Response
    {
        return view('org.create');
    }

    public function store(OrgStoreRequest $request): Response
    {
        $org = Org::create($request->validated());

        $request->session()->flash('org.id', $org->id);

        return redirect()->route('orgs.index');
    }

    public function show(Request $request, Org $org): Response
    {
        return view('org.show', compact('org'));
    }

    public function edit(Request $request, Org $org): Response
    {
        return view('org.edit', compact('org'));
    }

    public function update(OrgUpdateRequest $request, Org $org): Response
    {
        $org->update($request->validated());

        $request->session()->flash('org.id', $org->id);

        return redirect()->route('orgs.index');
    }

    public function destroy(Request $request, Org $org): Response
    {
        $org->delete();

        return redirect()->route('orgs.index');
    }
}
