<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CandidatureController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Candidature::class);

        $candidatures = auth()->user()
            ->candidatures()
            ->withCount('entretiens')
            ->get();

        return view('candidatures.index', compact('candidatures'));
    }

    public function create()
    {
        $this->authorize('create', Candidature::class);

        return view('candidatures.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Candidature::class);

        $validated = $request->validate([
            'company'    => 'required|string|max:255',
            'position'   => 'required|string|max:255',
            'offer_url'  => 'nullable|url',
            'status'     => 'required|in:sent,interview,offer,rejected,withdrawn',
            'priority'   => 'required|in:low,medium,high',
            'notes'      => 'nullable|string',
            'applied_at' => 'required|date',
        ]);

        Candidature::create([...$validated, 'user_id' => auth()->id()]);

        return redirect()->route('candidatures.index')
            ->with('success', 'Candidature créée avec succès.');
    }

    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature);

        $candidature->load('entretiens');

        return view('candidatures.show', compact('candidature'));
    }

    public function edit(Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        return view('candidatures.edit', compact('candidature'));
    }

    public function update(Request $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $validated = $request->validate([
            'company'    => 'required|string|max:255',
            'position'   => 'required|string|max:255',
            'offer_url'  => 'nullable|url',
            'status'     => 'required|in:sent,interview,offer,rejected,withdrawn',
            'priority'   => 'required|in:low,medium,high',
            'notes'      => 'nullable|string',
            'applied_at' => 'required|date',
        ]);

        $candidature->update($validated);

        return redirect()->route('candidatures.index')
            ->with('success', 'Candidature mise à jour avec succès.');
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);

        $candidature->delete();

        return redirect()->route('candidatures.index')
            ->with('success', 'Candidature archivée avec succès.');
    }

    public function archives()
    {
        $candidatures = Candidature::onlyTrashed()
            ->where('user_id', auth()->id())
            ->get();

        return view('candidatures.archives', compact('candidatures'));
    }

    public function restore($id)
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $candidature);

        $candidature->restore();

        return redirect()->route('candidatures.index')
            ->with('success', 'Candidature restaurée avec succès.');
    }
}