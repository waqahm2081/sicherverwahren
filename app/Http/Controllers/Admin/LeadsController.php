<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query()->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(20)->withQueryString();

        return view('admin.leads.index', [
            'leads'    => $leads,
            'statuses' => Lead::statuses(),
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'status' => 'required|in:new,contacted,customer',
            'notes'  => 'nullable|string|max:5000',
        ]);

        $lead->update($data);

        return back()->with('success', 'Lead erfolgreich aktualisiert.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead gelöscht.');
    }
}
