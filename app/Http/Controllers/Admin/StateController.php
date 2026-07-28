<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:states,name',
        ]);

        State::create(['name' => $request->name]);

        return back()->with('success', 'State added successfully.');
    }

    public function destroy($id)
    {
        $state = State::findOrFail($id);
        
        // Prevent deletion if associated with schools
        if ($state->schools()->exists()) {
            return back()->withErrors(['state' => 'Cannot delete state because it has associated schools.']);
        }
        
        $state->delete();
        
        return back()->with('success', 'State deleted successfully.');
    }
}
