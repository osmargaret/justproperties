<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TogglePropertyBookmark extends Controller
{
    public function __invoke(Request $request, Property $property): RedirectResponse
    {
        $bookmark = $request->user()->savedProperties()
            ->where('property_id', $property->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $message = __('Property removed from bookmarks.');
        } else {
            $request->user()->savedProperties()->create(['property_id' => $property->id]);
            $message = __('Property added to bookmarks.');
        }

        return back()->with('status', $message);
    }
}
