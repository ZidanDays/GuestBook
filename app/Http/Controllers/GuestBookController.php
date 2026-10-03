<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestBookRequest;
use App\Http\Requests\UpdateGuestBookRequest;
use App\Models\GuestBook;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request; // ✅ BENAR

class GuestBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // $guests = GuestBook::latest('tanggal')->paginate(10);
        // return view('guest_book.index', compact('guests'));

        $query = GuestBook::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik_nip', 'like', "%{$search}%")
                    ->orWhere('maksud_tujuan', 'like', "%{$search}%");
        }

        $guests = $query->latest('tanggal')->latest('id')->paginate(10)->withQueryString();

        return view('guest_book.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('guest_book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuestBookRequest $request)
    {
        //
        $data = $request->validated();

        //1. Penanganan jika Foto berupa upload File biasa
        if ($request->hasfile('foto')) {
            $data['foto'] = $request->file('foto')->store('visitors', 'public');

        }

        //2. Penanganan jika Foto ditangkap dari WebCam (format Base64)
        elseif ($request->filled('foto_webcam')) {
            $img = $request->input('foto_webcam');
            $imageParts = explode(";base64,", $img);

            if (count($imageParts) === 2) {
                $imageDecoded = base64_decode($imageParts[1]);
                $filename = 'visitors/' . Str::random(20) . '.png';

                Storage::disk('public')->put($filename, $imageDecoded);
                $data['foto'] = $filename;
            }
        }

        GuestBook::create($data);

        return redirect()->route('guest-books.create')
        ->with('success', 'Data tamu berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GuestBook $guestBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuestBook $guestBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuestBookRequest $request, GuestBook $guestBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuestBook $guestBook)
    {
        //
    }
}
