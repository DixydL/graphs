<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function child()
    {
        return $this->belongsToMany(Graph::class, 'graph_bind', 'parent_id', 'child_id', 'id', 'id')->withPivot("weight");
    }

    public function parent()
    {
        return $this->belongsToMany(Graph::class, 'graph_bind', 'child_id', 'parent_id', 'id', 'id')->withPivot("weight");
    }
}
