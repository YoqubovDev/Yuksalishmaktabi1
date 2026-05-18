<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {

        $contact = Contact::latest()->first();
        return view('aloqa', compact('contact'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address'        => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:255',
            'fax'            => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'work_time'      => 'nullable|string|max:255',
            'lunch_time'     => 'nullable|string|max:255',
            'bus'            => 'nullable|string|max:255',
            'marshrut'       => 'nullable|string|max:255',
            'stop'           => 'nullable|string|max:255',
            'telegram'       => 'nullable|url|max:255',
            'facebook'       => 'nullable|url|max:255',
            'youtube'        => 'nullable|url|max:255',
            'instagram'      => 'nullable|url|max:255',
            'map_link'       => 'nullable|url|max:255',
            'rating'         => 'nullable|numeric|min:0|max:5',
            'reviews_count'  => 'nullable|integer|min:0',
        ]);

        $contact = Contact::create($validated);

        return redirect()->route('contact')->with('success', 'Aloqa ma\'lumotlari muvaffaqiyatli qo\'shildi!');
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'address'        => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:255',
            'fax'            => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'work_time'      => 'nullable|string|max:255',
            'lunch_time'     => 'nullable|string|max:255',
            'bus'            => 'nullable|string|max:255',
            'marshrut'       => 'nullable|string|max:255',
            'stop'           => 'nullable|string|max:255',
            'telegram'       => 'nullable|url|max:255',
            'facebook'       => 'nullable|url|max:255',
            'youtube'        => 'nullable|url|max:255',
            'instagram'      => 'nullable|url|max:255',
            'map_link'       => 'nullable|url|max:255',
            'rating'         => 'nullable|numeric|min:0|max:5',
            'reviews_count'  => 'nullable|integer|min:0',
        ]);

        $contact->update($validated);

        return redirect()->route('contact')->with('success', 'Aloqa ma\'lumotlari yangilandi!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact')->with('success', 'Aloqa ma\'lumotlari o\'chirildi!');
    }

    public function storeEnrollment(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'class'      => 'required|string|max:50',
            'phone'      => 'required|string|max:50',
        ]);

        // Prepend '+998' if phone doesn't have it, since input has '+998' label prepended in frontend
        $phone = $validated['phone'];
        if (!str_starts_with($phone, '+998')) {
            $phone = '+998' . $phone;
        }

        Enrollment::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'class'      => $validated['class'] . '-sinf',
            'phone'      => $phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Arizangiz muvaffaqiyatli qabul qilindi!'
        ]);
    }
}
