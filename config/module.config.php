<?php
return [
    'router' => [
        'routes' => [
            'api-rest' => [
                'child_routes' => [
                    'nightclub' => [
                        'child_routes' => [
                            'girl' => [
                                'child_routes' => [
                                    'review' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/review[/:review_id]',
                                            'defaults' => [
                                                'controller' => 'Strapieno\NightClubGirlReview\Api\V1\Rest\Controller'
                                            ],
                                            'constraints' => [
                                                'review_id' => '[0-9a-f]{24}'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'matryoshka-apigility' => [
        'matryoshka-connected' => [
            'Strapieno\NightClubGirlReview\Api\V1\Rest\ConnectedResource' => [
                'model' => 'Strapieno\NightClubGirlReview\Model\ReviewModelService',
                'collection_criteria' => 'Strapieno\NightClubGirlReview\Model\Criteria\ReviewCollectionCriteria',
                'entity_criteria' => 'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria',
                'hydrator' => 'NightClubGirlReviewApiHydrator'
            ]
        ]
    ],
    'zf-rest' => [
        'Strapieno\NightClubGirlReview\Api\V1\Rest\Controller' => [
            'service_name' => 'NightClubGirlReview',
            'listener' => 'Strapieno\NightClubGirlReview\Api\V1\Rest\ConnectedResource',
            'route_name' => 'api-rest/nightclub/girl/review',
            'route_identifier_name' => 'review_id',
            'collection_name' => 'reviews',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                'place_id'
            ],
            'page_size' => 10,
            'page_size_param' => 'page_size',
            'collection_class' => 'Zend\Paginator\Paginator', // FIXME function?
        ]
    ],
    'zf-content-negotiation' => [
        'accept_whitelist' => [
            'Strapieno\NightClubGirlReview\Api\V1\Rest\Controller' => [
                'application/hal+json',
                'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Strapieno\NightClubGirlReview\Api\V1\Rest\Controller' => [
                'application/json'
            ],
        ],
    ],
    'zf-hal' => [
        // map each class (by name) to their metadata mappings
        'metadata_map' => [
            'Strapieno\NightClubGirlReview\Model\Entity\ReviewEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api-rest/nightclub/girl/review',
                'route_identifier_name' => 'review_id',
                'hydrator' => 'NightClubGirlReviewApiHydrator',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Strapieno\NightClubGirlReview\Api\V1\Rest\Controller' => [
            'input_filter' => 'Strapieno\NightClubGirlReview\Api\InputFilter\DefaultInputFilter',
        ]
    ],
    'strapieno_input_filter_specs' => [
        'Strapieno\NightClubGirlReview\Api\InputFilter\DefaultReviewInputFilter' => [
            'merge' => 'Strapieno\NightClubGirlReview\Model\InputFilter\DefaultReviewInputFilter',
        ],
        'Strapieno\NightClubGirlReview\Api\InputFilter\DefaultInputFilter' => [
            'merge' => 'Strapieno\NightClubGirlReview\Model\InputFilter\DefaultInputFilter',
            "girl_id" => [
                'name' => 'girl_id',
                'require' => true,
                'allow_empty' => false
            ],
            'review_body',[
                'name' => 'review_body',
                'require' => true,
                'allow_empty' => false
            ],
            "rating" => [
                'name' => 'rating',
                'type' => 'Strapieno\NightClubGirlReview\Api\InputFilter\DefaultReviewInputFilter',
            ]
        ]
    ]
];
