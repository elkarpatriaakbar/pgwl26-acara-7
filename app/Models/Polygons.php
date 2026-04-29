<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Polygons extends Model
{
  protected $table = 'polygons';
	protected $guarded = ['id'];

	public function polygons()
{
    return $this->selectRaw('id, name, description, image_path, image_name, ST_AsGeoJSON(geom) as geom, ST_Area(geom::geography) as area, created_at, updated_at')
        ->get();
}

public function polygon($id)
{
    return $this->selectRaw('id, name, description, image_path, image_name, ST_AsGeoJSON(geom) as geom, ST_Area(geom::geography) as area, created_at, updated_at')
        ->where('id', $id)
        ->first();
}
}
