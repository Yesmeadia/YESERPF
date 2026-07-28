<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zones,name',
        ]);

        Zone::create(['name' => $request->name]);

        return back()->with('success', 'Zone added successfully.');
    }

    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);
        
        // Prevent deletion if associated with schools
        if ($zone->schools()->exists()) {
            return back()->withErrors(['zone' => 'Cannot delete zone because it has associated schools.']);
        }
        
        $zone->delete();
        
        return back()->with('success', 'Zone deleted successfully.');
    }
}
