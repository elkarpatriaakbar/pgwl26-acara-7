<?php

namespace App\Http\Controllers;

use App\Models\Polylines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolylineController extends Controller
{
	public function __construct()
	{
		$this->polyline = new Polylines();
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'description' => 'required',
			'geom_polyline' => 'required',
			'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
		]);

		$data = [
			'name' => $request->name,
			'description' => $request->description,
			'geom' => DB::raw("ST_GeomFromText('$request->geom_polyline')")
		];

		if ($request->hasFile('image')) {
			$data['image_path'] = $request->file('image')->store('uploads', 'public');
			$data['image_name'] = $request->file('image')->getClientOriginalName();
		}

		try {
			Polylines::create($data);
			return redirect()->back()->with('success', 'Polyline created successfully');
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Failed to create polyline: ' . $e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$data = [
			'title' => 'Edit Polyline',
			'page' => 'edit-polyline',
			'id' => $id
		];

		return view('edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$request->validate([
			'name' => 'required',
			'description' => 'required',
			'geom' => 'required',
			'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
		]);

		$data = [
			'name' => $request->name,
			'description' => $request->description,
			'geom' => DB::raw("ST_GeomFromText('$request->geom')")
		];

		if ($request->hasFile('image')) {
			$data['image_path'] = $request->file('image')->store('uploads', 'public');
			$data['image_name'] = $request->file('image')->getClientOriginalName();
		}

		if (!$this->polyline->find($id)->update($data)) {
			return redirect()->back()->with('error', 'Failed to update polyline');
		}

		return redirect()->route('/')->with('success', 'Polyline updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		if (!$this->polyline->destroy($id)) {
			return redirect()->back()->with('error', 'Failed to delete polyline');
		}

		return redirect()->back()->with('success', 'Polyline deleted successfully');
	}
}
