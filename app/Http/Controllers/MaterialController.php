<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Material;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('class')->get();
        $type_menu = '';
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
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
        Alert::success('Hore!', 'Materi Berhasil Ditambahkan');
        return redirect()->route('materials.index');
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

    public function update(Request $request, Material $material)
    {
        $material->update($request->all());
        Alert::success('Hore!', 'Materi Berhasil DiPerbarui');
        return redirect()->route('materials.index');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index');
    }

}
