<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/1
 * Time: 4:01 PM
 */

namespace App\controllers\search;

use Carbon\Carbon;
use Framework\Core\Controller;

use Zl\Compose\Search\EsClient;

/**
 * Class Job
 * @package App\controllers\search
 *
 *
 *
 *
 */
class Job extends Controller
{
    protected $es;

    public function __construct()
    {
        parent::__construct();
        $this->es = new EsClient([
            'host' => [zenv('ES_HOST', '')]
        ]);
    }

    public function index()
    {
        $a = $this->es->get([
            'index' => request('index'),
            'type' => request('type'),
            'body' => [],
            'size' => 1,
            'client' => [
                'verbose' => false, // true 返回内容会多包含一层body、 影响内部逻辑 慎用
            ]
        ]);
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->responseTrue([$a]);
        }
        return $this->responseFalse([$a]);
    }

    public function create()
    {
        $insert = [
            "id" => mt_rand(1, 10000000),
            "name" => str_random(4),
            "url" => str_random(4),
            "description" => json_encode([1,2]),
            "content" => str_random(46),
            "pv" => mt_rand(10000, 10000000),
            "status" => mt_rand(0, 1),
            "created_at" => Carbon::now()->format('Y-m-d'),
            "updated_at" => Carbon::now()->format('Y-m-d'),
        ];

        var_export(request('id', "111"));die;

        $insertReturn = $this->es->create([
            'index' => 'search',
            'type' => 'product',
            'id' => mt_rand(1, 100000000),
            'op_type' => 'create',
            'body' => $insert
        ]);

        $insertReturn['_source'] = $insert;

        return $this->responseTrue($insertReturn);
    }

    public function delete()
    {
        $deleteReturn = $this->es->delete(
            'search',
            'product',
            request('id')
        );

        return $this->responseTrue($deleteReturn);
    }

    public function exist()
    {
        /**
         * op_type
         * https://es.xiaoleilu.com/030_Data/30_Create.html
         */
        $existReturn = $this->es->exist(
            'search',
            'product',
            request('id')
        );

        if (!$existReturn) {
            return $this->responseFalse(['exist' => false]);
        }

        return $this->responseTrue(['exist' => true]);
    }

    public function updateByVersion()
    {
        $updateData = [
            "id" => mt_rand(1, 10000000),
            "name" => str_random(3),
            "title" => str_random(10), // my cat
            '_id' => request('id'),
        ];

        $existReturn = $this->es->updateByVersion(
            'search',
            'product',
            request('id'),
            request('version'),
            $updateData
        );

        if (!$existReturn) {
            return $this->responseFalse($existReturn);
        }

        return $this->responseTrue($existReturn);
    }

    public function update()
    {
        $updateData = [
            "id" => mt_rand(1, 10000000),
            "name" => str_random(3),
            "title" => str_random(10), // my cat
        ];

        $existReturn = $this->es->update(
            'search',
            'product',
            request('id'),
            $updateData
        );

        if (!$existReturn) {
            return $this->responseFalse($existReturn);
        }

        return $this->responseTrue($updateData);
    }

    public function updateByScript()
    {
        $updateData = $this->es->updateByScript(
            'search',
            'product',
            request('id'),
            [
                'script' => 'status += counter',
                'params' => [
                    'counter' => 10
                ]
            ]
        );

        if (!$updateData) {
            return $this->responseFalse($updateData);
        }

        return $this->responseTrue($updateData);
    }

    public function lists()
    {
//       $this->es->search();
    }

    public function mGet()
    {
        // error
        $mGetData =
            [
                'type' => 'product',
                'index' => 'search',
                'body' => [
                    'docs' => [
                        ['_id' => 26],
                        ['_id' => 27]
                    ]
                ]
            ];

        $result = $this->es->mGet($mGetData);
//
//        $result = $this->es->mGet([
//            'type' => 'product',
//            'index' => 'search',
//            'body' => ['ids' => [27, 26]],
//            '_source' => ['sort', 'status']
//        ]);


        return $this->responseTrue($result);
    }


    public function sea()
    {
        $result = $this->es->get([
            'index' => 'search',
            'type' => 'product',
            'id' => request('id'),
            '_source_include' => [
                'url', 'name'
            ],
        ]);


        return $this->responseTrue($result);
    }

    public function search()
    {
        $a = [];
        // 短语匹配 高亮效果
//        $a = [
//            'index' => request('index'),
//            'type' => request('type'),
//            'body' => [
//                'query' => [
//                    'match_phrase' => [
//                        'text' => 'this out'
//                    ]
//                ],
//
//                'highlight' => [
//                    'fields' => [
//                        'text' => (object)[]
//                    ]
//                ]
//            ],
//
//
//        ];

//        'body' => [
//        'query' => [
//
//                        'filter' => [
//                            'range' => [
//                                'id' => ['gt' => 20]
//                            ]
//                        ],
//
//            'match' => [
//                'name' => "0"
//            ],
//
//
//
//
//        ],
//
//    ],

//        [
//            'query' => [
//                'constant_score' => [
//                    'filter' => [
//                        'range' => [
//                            'id' => [
//                                'lte' => 3323654
//                            ]
//                        ],
//                    ],
//                ],
//
//            ]
//        ]


        //'q' => '9532' 全字段搜索
//
//        [
//            'query' => [
//                 'bool' => [
//                     'must' => [
//                           ['terms' => ['product_id' => ['8703297', '9911628', '4826825']]]
//                        ],
//                 'must_not' => [
//                       ['term' => ['_id' => 'x2DXHGgBYMfMObGrx_p6']],
//                       ['term' => ['status' => 1]],
//                     ]
//                ]
//            ]
//        ];


//                [
//                    'query' => [
//                        'bool' => [
//                            'must_not' => [
//                                'term' => [
//                                    'title' => '1'
//                                ]
//                            ]
//                        ]
//                    ]
//                ]
//           bool过滤器 目前5之后已经取消的了filter过滤器  相关文档存在错误


//            [
//                'query' =>
//                    [
//                        'term' => [
//                                'title' => '5c2c279532ea6'
//                        ]
//                    ]
//            ] 常用的 term 查询， 可以用它处理数字（numbers）、布尔值（Booleans）、日期（dates）以及文本（text）
//
//                [
//                    'query' => [
//                        'constant_score' => [
//                            'filter' => [
//                                'term' => [
//                                    /**
//                                     *  如果想达到精准匹配 那么需要修改map类型
//                                     *  http://localhost:9200/zxz/ztype/_mapping 查看map类型
//                                     * '5c2-c27+9532-ea6' 会解析成 5c2 c27 9532 ea6 丢失了连接符号和 # 哈希符
//                                     */
//                                    /**
//                                     * curl -X GET "localhost:9200/zxz/_analyze" -H 'Content-Type: application/json' -d
//                                            '
//                                            {
//                                            "field": "title",
//                                            "text": "X+HDKA1+293#fJ3"
//                                            }
//                                            '
//                                     */
//                                    'title' => '1293'
//                                ]
//                            ]
//                        ]
//                    ]
//                ]

        //通常当查找一个精确值的时候，我们不希望对查询进行评分计算。只希望对文档进行包括或排除的计算，
        //所以我们会使用 constant_score 查询以非评分模式来执行 term 查询并以一作为统一评分。
//              'body' => [
//                  'query' =>  [
//                        'match' => [
//                               'title' => 'my cat'
//                          ]
//                    ]
//               ]
//
//            'body' => [
//                'query' => [
//                    'bool' => [
//                        'filter' => [
//                            'term' => [ 'title' => request('keyword', '')]
//                        ]
//                    ]
//                ]
//            ]
//
//            'body' => [
//                'query' => [
//                    'bool' => [
//                        'must' => [
//                            ['term' => ['title' => 'cat']],
//                            ['term' => ['title' => 'my']],
//                        ]
//                    ]
//                ],


        $ret = $this->es->connect()->search($a);

        return $this->responseTrue($ret);
    }


    public function aggs()
    {
        $a = [
            'index' => 'search',
            'type' => 'product',
            'body' => [
                'aggs' => [
                    'all_interests' => [
                        'terms' => [
                            'field' => 'url'
                        ],
                    ],
                    'all_name' => [
                        'terms' => [
                            'field' => 'name'
                        ]
                    ]
                ],
                'query' => [
                    'match' => [
                        'android_url' => 22
                    ]
                ]
            ]
        ];
        $ret = $this->es->connect()->search($a);
        return $this->responseTrue($ret);
    }

    public function putProperty()
    {

        /*

        index/_mapping/product
curl -X PUT "localhost:9200/search/_mapping/product" -H "Content-type: application/json"  -d   '{
  "properties": {
    "url": {
      "type":     "text",
      "fielddata": true
    }
  }
}'
         */
    }

    public function clusterHealth()
    {
        $health = $this->es->clusterHealth();

        return $this->responseTrue($health);
    }

    public function createIndex()
    {
        $indexData = [
            'index' => 'test',
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 1
                ]
            ]];

        $this->es->createIndices($indexData);
        return $this->responseTrue(true);

    }
}