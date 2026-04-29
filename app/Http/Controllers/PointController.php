<?php

namespace App\Http\Controllers;

use App\Models\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
	public function __construct()
	{
		$this->point = new Points();
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
			'geom_point' => 'required',
			'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
		]);

		$data = [
			'name' => $request->name,
			'description' => $request->description,
			'geom' => DB::raw("ST_GeomFromText('$request->geom_point')")
		];

		if ($request->hasFile('image')) {
			$data['image_path'] = $request->file('image')->store('uploads', 'public');
			$data['image_name'] = $request->file('image')->getClientOriginalName();
		}

		try {
			Points::create($data);
			return redirect()->back()->with('success', 'Point created successfully');
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Failed to create point: ' . $e->getMessage());
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
			'title' => 'Edit Point',
			'page' => 'edit-point',
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

		if (!$this->point->find($id)->update($data)) {
			return redirect()->back()->with('error', 'Failed to update point');
		}

		return redirect()->route('/')->with('success', 'Point updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		if (!$this->point->destroy($id)) {
			return redirect()->back()->with('error', 'Failed to delete point');
		}

		return redirect()->back()->with('success', 'Point deleted successfully');
	}
}
