<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Polylines extends Model
{
  protected $table = 'polylines';
	protected $guarded = ['id'];

	public function polylines()
{
    return $this->selectRaw('id, name, description, image_path, ST_AsGeoJSON(geom) as geom, ST_Length(geom::geography) as length, created_at, updated_at')
        ->get();
}

public function polyline($id)
{
    return $this->selectRaw('id, name, description, image_path, ST_AsGeoJSON(geom) as geom, ST_Length(geom::geography) as length, created_at, updated_at')
        ->where('id', $id)
        ->first();
}
}
