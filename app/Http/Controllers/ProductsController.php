<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSku;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends Controller
{
    /*
    public function index(Request $request)
    {
        $builder = Product::query()->where('on_sale', true);

        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }
        //如果有传入category_id字段那么
        if ($request->input('category_id') && $category = Category::find($request->input('category_id'))) {
            //如果是一个父类目
            if ($category->is_directory) {
                // 则筛选出该父类目下所有子类目的商品
                $builder->whereHas('category', function ($query) use ($category) {
                    $query->where('path', 'like', $category->path . $category->id . '-%');
                });
            } else {
                //如果不是一个父类目 ，则直接筛选c此类目下的商品
                $builder->where('category_id', $category->id);
            }
        }

        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $products = $builder->paginate(16);

        return view('products.index', [
            'products' => $products,
            'filters' => [
                'search' => $search,
                'order' => $order
            ],
            'category' => $category ?? null,
        ]);
    }
    */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 16;
        //构建查询
        $params = [
            'index' => 'products',
            'body' => [
                'from' => ($page - 1) * $perPage,
                'size' => $perPage,
                'query' => [
                    'bool' => [
                        'filter' => [
                            ['term' => ['on_sale' => true]]
                        ],
                    ],
                ],
            ],
        ];
        //是否有提交order 参数
        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    $params['body']['sort'] = [[$m[1] => $m[2]]];
                }
            }
        }
        //分类查询
        if ($request->input('category_id') && $category = Category::find($request->input('category_id'))) {
            if ($category->is_directory) {
                // 如果是一个父类目，则使用 category_path 来筛选
                $params['body']['query']['bool']['filter'][] = [
                    'prefix' => ['category_path' => $category->path . $category->id . '-'],
                ];
            } else {
                //否则直接通过category_id 来搜索
                $params['body']['query']['bool']['filter'][] = ['term' => ['category_id' => $category->id]];
            }
        }
        //关键字查询 多字段匹配查询：
        if ($search = $request->input('search', '')) {
            // 将搜索词根据空格拆分成数组，并过滤掉空项
            $keywords = array_filter(explode(' ', $search));
            $params['body']['query']['bool']['must'] = [];
            foreach ($keywords as $keyword) {
                $params['body']['query']['bool']['must'][] = [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => [
                            'title^3',
                            'long_title^2',
                            'category^2', //类目名称
                            'description',
                            'skus_title',
                            'skus_description',
                            'properties_value',
                        ],
                    ],
                ];
            }
        }
        //分面搜索 的 聚合
        if ($search || isset($category)) {
            $params['body']['aggs'] = [
                'properties' => [
                    'nested' => [
                        'path' => 'properties',
                    ],
                    'aggs' => [
                        'properties' => [
                            'terms' => [
                                'field' => 'properties.name',
                            ],
                            'aggs' => [
                                'value' => [
                                    'terms' => ['field' => 'properties.value'],
                                ]
                            ],
                        ]
                    ],
                ],
            ];
        }

        //按属性值筛选
        $propertiesFilters = [];
        if ($filterString = $request->input('filters')) {
            //将获取到的字符串用符号｜ 拆分成数组；
            $filterArray = explode('|', $filterString);
            foreach ($filterArray as $filter) {
                // 将字符串用符号 : 拆分成两部分并且分别赋值给 $name 和 $value 两个变量
                list($name, $value) = explode(':', $filter);
                //将用户筛选的属性添加到数组中
                $propertiesFilters[$name] = $value;
                // 添加到 filter 类型中
                $params['body']['query']['bool']['filter'][] = [
                    'nested' => [
                        'path' => "properties",
                        'query' => [
                            ['term' => ['properties.name' => $name]],
                            ['term' => ['properties.value' => $value]],
                        ],
                    ]
                ];
            }
        }

        $result = app('es')->search($params);
        // 通过 collect 函数将返回结果转为集合，并通过集合的 pluck 方法取到返回的商品 ID 数组
        $productIds = collect($result['hits']['hits'])->pluck('_id')->all();
        // 通过 whereIn 方法从数据库中读取商品数据
        $products = Product::query()
            ->whereIn('id', $productIds)
            // orderByRaw 可以让我们用原生的 SQL 来给查询结果排序
            ->orderByRaw(sprintf("FIND_IN_SET(id,'%s')", join(',', $productIds)))
            ->get();
        // 返回一个 LengthAwarePaginator 对象
        $pager = new LengthAwarePaginator($products, $result['hits']['total']['value'], $perPage, $page, [
            'path' => route('products.index', false),
        ]);

        $properties = [];
        // 如果返回结果里有 aggregations 字段，说明做了分面搜索
        if (isset($result['aggregations'])) {
            // 使用 collect 函数将返回值转为集合
            $properties = collect($result['aggregations']['properties']['properties']['buckets'])->map(function ($bucket) {
                return ['key' => $bucket['key'], 'values' => collect($bucket['value']['buckets'])->pluck('key')->all()];
            })->filter(function($property) use ($propertiesFilters){
                // 过滤掉只剩下一个值 或者 已经在筛选条件里的属性
                return count($property['values']) > 1 && !isset($propertiesFilters[$property['key']]);
            });
        }

        return view('products.index', [
            'products' => $pager,
            'filters' => [
                'search' => $search,
                'order' => $order
            ],
            'category' => $category ?? null,
            'properties' => $properties,
            'propertyFilters' => $propertiesFilters,
        ]);
    }

    public function show(Product $product, Request $request)
    {
        if (!$product->on_sale) {
            throw new InvalidRequestException("商品未上架");
        }
        $favored = false;
        if ($user = $request->user()) {
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }
        //商品的评论
        $reviews = OrderItem::query()
            ->with(['order.user', 'productSku'])
            ->where('product_id', $product->id)
            ->whereNotNull('reviewed_at')//已经评价的
            ->orderBy('reviewed_at', 'desc')
            ->limit(10)
            ->get();
        return view('products.show', ['product' => $product, 'favored' => $favored, 'reviews' => $reviews]);
    }

    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteProducts()->find($product->id)) {
            return [];
        }
        $user->favoriteProducts()->attach($product);
        return [];
    }

    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);
        return [];
    }

    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);
        return view('products.favorites', ['products' => $products]);
    }
}
