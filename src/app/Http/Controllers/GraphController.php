<?php

namespace App\Http\Controllers;

use App\Helper\GraphHelper;
use App\Models\Graph;

class GraphController extends Controller
{
    public function index()
    {
        $g = new GraphHelper();
        $g->preOrder(Graph::where(['name' => 'A'])->get());

        echo "<br>";
        echo "<br>";
        $g->clearVisited();
        $g->postOrden(Graph::where(['name' => 'A'])->get());

        echo "<br>";
        echo "<br>";
        $g->clearVisited();
        $g->listOrden(Graph::where(['name' => 'B'])->get());

        foreach (Graph::all() as $graph) {
            foreach ($graph->child as $graphChild) {
                $graphsData[$graph->name][$graphChild->name] = $graphChild->pivot->weight;
            }
            foreach ($graph->parent as $graphParent) {
                $graphsData[$graph->name][$graphParent->name] = $graphParent->pivot->weight;
            }
        }
        echo "<br>";
        echo "<br>";
        $g->shortPath($graphsData, "A", "B");
        $g->shortPath($graphsData, "E", "R");
    }
}
