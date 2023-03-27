<?php

namespace App\Services;

use App\Models\Build;
use App\Models\City;
use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BuildService
{
    public function __construct(
        private Build $buildModel,
        private City $cityModel,
        private Type $typeModel)
    { }
    private function getKeys(array $array)
    {
        $result = [];
        foreach($array as $key => $value)
        {
            if($value === true)
                $result[] = $key;
        }
        return $result;
    }
    private function getPaginateCollection(array $collection, int $currentPage, $perPage = 10): LengthAwarePaginator
    {
        $collection = new Collection($collection);

        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
    }
    public function handle(array $filds)
    {
        $query = $this->buildModel;
        if($ids = $this->getKeys($filds['city_id']))
        {
            $query = $query->whereHas('cities', function ($query) use ($ids) {
                $query->whereIn('city_id', $ids);
            });
        }
        if ($ids = $this->getKeys($filds['type_id'])) {
            $query = $query->whereHas('types', function ($query) use ($ids) {
                $query->whereIn('type_id', $ids);
            });
        }
        $items = $query->get();
        foreach($items as &$item)
            $item->getMedia('img');
        $paginated = $this->getPaginateCollection($items->toArray(), $filds['page'],3);
        return ['items'=> $paginated,'cities'=>$this->cityModel->get(),'types'=>$this->typeModel->get()];
    }
}