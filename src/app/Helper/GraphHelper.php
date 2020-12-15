<?php

namespace App\Helper;

use Illuminate\Database\Eloquent\Collection;
use SplPriorityQueue;
use SplStack;

class GraphHelper
{
    public array $visited;
    //От рута до листов
    public function preOrder(Collection $graphs)
    {
        if ($graphs->isEmpty()) {
            return;
        }
        foreach ($graphs as $graph) {
            if (isset($this->visited[$graph->name])) {
                return;
            }

            echo "$graph->name ->";
            $this->visited[$graph->name] = true;
            $this->preOrder($graph->child);
        }
    }

    //От листов и завершить главным узлом
    public function postOrden(Collection $graphs)
    {
        if ($graphs->isEmpty()) {
            return;
        }
        foreach ($graphs as $graph) {
            if (isset($this->visited[$graph->name])) {
                return;
            }

            $this->visited[$graph->name] = true;
            $this->postOrden($graph->child);
            echo "$graph->name ->";
        }
    }

    //От листа
    public function listOrden(Collection $graphs)
    {
        if ($graphs->isEmpty()) {
            return;
        }
        foreach ($graphs as $graph) {
            if (isset($this->visited[$graph->name])) {
                return;
            }

            echo "$graph->name ->";
            $this->visited[$graph->name] = true;

            $this->listOrden($graph->parent);
        }
    }

    public function clearVisited()
    {
        $this->visited = [];
    }

    //Поиск пути
    public function shortPath($graphs, $source, $purpose)
    {
        $queue = new SplPriorityQueue();
        $shortsPath = [];
        $predecessors = [];

        foreach ($graphs as $k => $adj) {
            $shortsPath[$k] = INF;
            $predecessors[$k] = null;
            foreach ($adj as $w => $cost) {
                $queue->insert($w, $cost);
            }
        }

        $shortsPath[$source] = 0;

        while (!$queue->isEmpty()) {
            $u = $queue->extract();
            if (!empty($graphs[$u])) {
                foreach ($graphs[$u] as $k => $cost) {
                    $alt = $shortsPath[$u] + $cost;
                    if ($alt < $shortsPath[$k]) {
                        $shortsPath[$k] = $alt;
                        $predecessors[$k] = $u;
                    }
                }
            }
        }

        $u = $purpose;
        $stak = new SplStack();
        $shortsPathist = 0;
        while (isset($predecessors[$u]) && $predecessors[$u]) {
            $stak->push($u);
            $shortsPathist += $graphs[$u][$predecessors[$u]];
            $u = $predecessors[$u];
        }

        if ($stak->isEmpty()) {
            echo "Нет пути из $source в $purpose<br>";
        } else {
            $stak->push($source);
            echo "$shortsPathist:";
            $sep = '';
            foreach ($stak as $k) {
                echo $sep, $k;
                $sep = '->';
            }
            echo "<br>";
        }
    }
}
