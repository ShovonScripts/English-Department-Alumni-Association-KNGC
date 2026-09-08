<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::query()->ordered()->paginate(30);

        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        return view('admin.batches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_year' => 'required|integer|min:1900|max:2100',
            'end_year' => 'required|integer|min:1900|max:2100|gt:start_year',
            'is_active' => 'boolean',
        ]);

        $label = Batch::makeLabel($validated['start_year'], $validated['end_year']);

        if (Batch::where('label', $label)->exists()) {
            return back()->withErrors(['start_year' => "Batch {$label} already exists."])->withInput();
        }

        $validated['label'] = $label;
        $validated['slug'] = Batch::uniqueSlug($label);
        $validated['is_active'] = $validated['is_active'] ?? true;

        $maxOrder = Batch::max('sort_order') ?? 0;
        $validated['sort_order'] = $maxOrder + 1;

        Batch::create($validated);

        return redirect()->route('admin.batches.index')
            ->with('status', "Batch {$label} created.");
    }

    public function edit(Batch $batch)
    {
        return view('admin.batches.edit', compact('batch'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;

        $batch->update($validated);

        return redirect()->route('admin.batches.index')
            ->with('status', "Batch {$batch->label} updated.");
    }

    public function destroy(Batch $batch)
    {
        $alumniCount = Alumni::where('batch', $batch->label)->count();

        if ($alumniCount > 0) {
            return redirect()->route('admin.batches.index')
                ->with('error', "Cannot delete batch {$batch->label} — {$alumniCount} alumni record(s) are assigned to it.");
        }

        $batch->delete();

        return redirect()->route('admin.batches.index')
            ->with('status', "Batch {$batch->label} deleted.");
    }
}
