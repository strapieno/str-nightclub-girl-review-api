<?php
namespace Strapieno\NightClubGirlReview\Api\V1\Listener;

use Matryoshka\Model\Object\ActiveRecord\ActiveRecordInterface;
use Matryoshka\Model\Wrapper\Mongo\Criteria\ActiveRecord\ActiveRecordCriteria;
use Strapieno\NightClubGirl\Model\GirlModelAwareInterface;
use Strapieno\NightClubGirl\Model\GirlModelAwareTrait;
use Strapieno\NightClubGirlReview\Model\Entity\ReviewEntity;
use Strapieno\Utils\Model\Object\AggregateRating\AggregateRatingAwareInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class NightClubGirlListener
 */
class NightClubGirlListener implements ListenerAggregateInterface, GirlModelAwareInterface
{
    use ListenerAggregateTrait;
    use GirlModelAwareTrait;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('create.post', [$this, 'onPostSave']);
    }

    /**
     * @param EventInterface $event
     */
    public function onPostSave(EventInterface $event)
    {
        // TODO add interface
        /** @var $review ReviewEntity */
        $review = $event->getParam('entity')->entity;

        $girl = $this->getGirlFromId($review->getGirlReference()->getId());

        if ($girl instanceof AggregateRatingAwareInterface && $girl instanceof ActiveRecordInterface) {

            $ratingCount = $girl->getAggregateRating()->getRatingCount() + $review->getRating()->getRatingValue();
            $girl->getAggregateRating()->setRatingCount($ratingCount);

            $reviewCount =  $girl->getAggregateRating()->getReviewCount() + 1;
            $girl->getAggregateRating()->setReviewCount($reviewCount);

            $partial = $girl->getAggregateRating()->getPartial();
            if (isset($partial[$review->getRating()->getRatingValue()])) {
                $partial[$review->getRating()->getRatingValue()] = $partial[$review->getRating()->getRatingValue()] + 1;
            } else {
                $partial[$review->getRating()->getRatingValue()] =   1;
            }
            $girl->getAggregateRating()->setPartial($partial);

            $girl->save();

        }
    }

    public function getGirlFromId($id)
    {
        return $this->getNightClubGirlModelService()->find((new ActiveRecordCriteria())->setId($id))->current();
    }
}