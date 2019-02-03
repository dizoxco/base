<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Repositories\Facades\SPRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder as DatabaseBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class SearchPanel extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'model', 'options', 'filters',
    ];

    protected $casts = [
        'options' => 'array',
        'filters' => 'array',
    ];
    /** @var array $tags */
    protected $tags = [];

    /** @var EloquentBuilder $builder */
    protected $builder;

    /** @var array $operators */
    public static $operators = ['=', '<>', '!=', '>', '>=', '<', '<='];

    public function result(Request $request, $with = []) : LengthAwarePaginator
    {
        $this->builder = $this->getAttribute('model')::query();

        // add filters to query
        if (! empty($this->getAttribute('filters'))) {
            $this->filters();
        }

        // add received options form user to query
        if (! empty($this->getAttribute('options'))) {
            $this->options($request);
        }

        if (! empty($this->tags)) {
            $this->optTags();
        }

//        dd($this->builder->toSql());
        return $this->builder->with($with)->paginate(request('per_page', 10));
    }

    private function optTags()
    {
        foreach ($this->tags as $tag) {
            $this->builder->whereIn('id', function (DatabaseBuilder $builder) use ($tag) {
                $builder->select('taggable_id')
                    ->distinct()
                    ->from('taggables')
                    ->where('taggable_type', $this->getAttribute('model'))
                    ->whereIn('tag_id', $tag);
            });
        }
    }

    private function filters() : void
    {
        $filters = $this->getAttribute('filters');
        foreach ($filters as $filter) {
            // is between , range or tag
            if (method_exists($this, $filter['query'])) {
                $method = $filter['query'];
            // is compare
            } elseif (in_array($filter['query'], self::$operators)) {
                $method = 'compare';
            }

            if (isset($method)) {
                call_user_func([$this, $method], $filter);
            }
        }
    }

    private function options(Request $request) : void
    {
        $url_params = $request->all();
        $options = $this->getAttribute('options');

        foreach ($url_params as $key => $value) {
            if (array_key_exists($key, $options)) {
                $option = $options[$key];

                $parameters = [$option];
                if (method_exists($this, $option['query'])) {
                    $method = $option['query'];
                } elseif (in_array($option['query'], self::$operators)) {
                    $method = 'Compare';
                }

                if (isset($method)) {
                    $parameters[] = $request->input($key);
                    call_user_func_array([$this, $method], $parameters);
                }
            }
        }
    }

    private function compare($filter, $index = null): void
    {
        if ($index !== null && is_array($filter['items'])) {
            $value = $filter['items'][$index]['value'];
        } else {
            $value = $filter['items'];
        }
        $this->builder->where($filter['field'], $filter['query'], $value);
    }

    private function between($filter): void
    {
        $this->builder->whereBetween($filter['field'], [$filter['min'], $filter['max']]);
    }

    private function range($filter, $index): void
    {
        $this->builder->whereBetween(
            $filter['field'], [
                $filter['ranges'][$index]['start'],
                $filter['ranges'][$index]['finish'],
            ]
        );
    }

    private function tag($filter, $indexes = null): void
    {
        $tags_id = array_pluck($filter['tag'], 'id');
        if ($indexes !== null) {
            $ids = [];
            foreach (array_wrap($indexes) as $index) {
                if (isset($tags_id[$index])) {
                    $ids[] = $tags_id[$index];
                }
            }
            $tags_id = $ids;
        }
        $this->tags[] = $tags_id;
    }

    private function like($filter, $needle)
    {
        if (is_string($needle)) {
            $columns = explode(',', trim($filter['like'], ','));
            foreach ($columns as $column) {
                $this->builder->where(function ($q) use ($column, $needle) {
                    return $q->orWhere($column, 'like', "%$needle%");
                });
            }
        }
    }

    private function order($orders, $index)
    {
        if (isset($orders['order'][$index])) {
            $query = $orders['order'][$index];
            $this->builder->orderBy($query['column'], $query['dir']);
        }
    }

    public function resolveRouteBinding($slug)
    {
        return SPRepo::findBySlug($slug);
    }
}
