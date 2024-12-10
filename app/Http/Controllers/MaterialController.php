<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('class')->get();
        $type_menu = '';
        return view('pages.material.index', compact('materials', 'type_menu'));
    }

    public function create()
    {
        $classes = Classes::all();
        $type_menu = '';
        return view('pages.material.create', compact('classes', 'type_menu'));
    }

    public function store(Request $request)
    {
        Material::create($request->all());
        return redirect()->route('materials.index')->with('success', 'Materi berhasil dibuat');
    }

    public function show(Material $material)
    {
        $type_menu = '';
        return view('pages.material.show', compact('material', 'type_menu'));
    }

    public function edit(Material $material)
    {
        $classes = Classes::all();
        $type_menu = '';
        return view('pages.material.edit', compact('material', 'classes', 'type_menu'));
    }

}
