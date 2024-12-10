<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Material;

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
}