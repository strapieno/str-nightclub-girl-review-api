<?php
namespace Strapieno\NightClubGirlReview\Api\V1\Hydrator;

use Matryoshka\Model\Hydrator\Strategy\HasOneStrategy;
use Strapieno\NightClub\Model\Entity\Reference\NightClubReference;
use Strapieno\NightClubGirl\Model\Entity\Reference\GirlReference;
use Strapieno\NightClubGirlReview\Model\Entity\Object\RatingObject;
use Strapieno\Utils\Hydrator\DateHystoryHydrator;
use Strapieno\Utils\Hydrator\Strategy\NamingStrategy\MapUnderscoreNamingStrategy;
use Strapieno\Utils\Hydrator\Strategy\ReferenceEntityCompressStrategy;

/**
 * Class ReviewHydrator
 */
class ReviewHydrator extends DateHystoryHydrator
{
    public function __construct($underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);

        // TODO add girl reference
        $this->setNamingStrategy(new MapUnderscoreNamingStrategy(['girl_id' => 'girlReference']));

        $this->addStrategy(
            'rating',
            new HasOneStrategy(new RatingObject(), false)
        );

        $this->addStrategy(
            'girl_id',
            new ReferenceEntityCompressStrategy(new GirlReference(), false)
        );

    }
}