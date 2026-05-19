<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schemes = Scheme::all();
        return view('admin.scheme.index', compact('schemes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.scheme.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $scheme = new Scheme();
        $scheme->scheme_name = $request->scheme_name;
        $scheme->save();

        return to_route('scheme.index')->with('success', 'Scheme Added Successsfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scheme = Scheme::find($id);
        return view('admin.scheme.show', compact('scheme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $scheme = Scheme::find($id);
        return view('admin.scheme.edit', compact('scheme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $scheme = Scheme::find($id);
        $scheme->scheme_name = $request->scheme_name;
        $scheme->update();

        return to_route('scheme.index')->with('success', 'Scheme Updated Successsfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scheme = Scheme::find($id);
        $scheme->delete();

        return to_route('scheme.index')->with('success', 'Scheme Deleted Successsfully');
    }
}
