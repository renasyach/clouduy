<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Member;
use Illuminate\Support\Facades\File;

class MemberController extends Controller
{
    /**
     * Display members for public view.
     */
    public function index()
    {
        $members = Member::orderBy('id', 'asc')->get();
        return view('members.index', compact('members'));
    }

    /**
     * Display dashboard list for administrative management.
     */
    public function dashboard()
    {
        $members = Member::orderBy('id', 'asc')->get();
        return view('members.dashboard', compact('members'));
    }

    /**
     * Show form to add a member.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store new member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:members,nim|max:50',
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'github' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Ensure folder public/images/members exists
            $destinationPath = public_path('images/members');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['photo'] = 'images/members/' . $imageName;
        }

        Member::create($data);

        return redirect()->route('dashboard')->with('success', 'Anggota kelompok berhasil ditambahkan.');
    }

    /**
     * Show form to edit member.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update member details.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:members,nim,' . $member->id,
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'github' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            // Delete old photo if it is not a seeded default (like andi.png, budi.png, etc.)
            if ($member->photo && !in_array($member->photo, ['images/members/andi.png', 'images/members/budi.png', 'images/members/citra.png', 'images/members/dewi.png'])) {
                $oldPhotoPath = public_path($member->photo);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('images/members');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['photo'] = 'images/members/' . $imageName;
        }

        $member->update($data);

        return redirect()->route('dashboard')->with('success', 'Data anggota kelompok berhasil diubah.');
    }

    /**
     * Delete a member.
     */
    public function destroy(Member $member)
    {
        // Delete photo if it's not a seeded default
        if ($member->photo && !in_array($member->photo, ['images/members/andi.png', 'images/members/budi.png', 'images/members/citra.png', 'images/members/dewi.png'])) {
            $photoPath = public_path($member->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $member->delete();

        return redirect()->route('dashboard')->with('success', 'Anggota kelompok berhasil dihapus.');
    }
}
