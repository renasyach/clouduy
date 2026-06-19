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
            'nama'           => 'required|string|max:255',
            'nim'            => 'required|string|unique:members,nim|max:50',
            'tanggung_jawab' => 'nullable|string',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('images/members');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $imageName);
            $data['foto'] = 'images/members/' . $imageName;
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
            'nama'           => 'required|string|max:255',
            'nim'            => 'required|string|max:50|unique:members,nim,' . $member->id,
            'tanggung_jawab' => 'nullable|string',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($member->foto) {
                $oldPhotoPath = public_path($member->foto);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            $image = $request->file('foto');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('images/members');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $imageName);
            $data['foto'] = 'images/members/' . $imageName;
        }

        $member->update($data);

        return redirect()->route('dashboard')->with('success', 'Data anggota kelompok berhasil diubah.');
    }

    /**
     * Delete a member.
     */
    public function destroy(Member $member)
    {
        if ($member->foto) {
            $photoPath = public_path($member->foto);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $member->delete();

        return redirect()->route('dashboard')->with('success', 'Anggota kelompok berhasil dihapus.');
    }
}
