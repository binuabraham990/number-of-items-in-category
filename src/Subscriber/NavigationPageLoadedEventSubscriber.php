<?php

namespace NtfxNumberOfItemsInCategory\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Storefront\Page\Navigation\NavigationPageLoadedEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Content\Product\SalesChannel\Listing\AbstractProductListingRoute;
use NtfxNumberOfItemsInCategory\Struct\ArticleCountStruct;

class NavigationPageLoadedEventSubscriber implements EventSubscriberInterface {

    private AbstractProductListingRoute $listingRoute;

    public function __construct(
            AbstractProductListingRoute $listingRoute
    ) {
        $this->listingRoute = $listingRoute;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array {
        return [
            NavigationPageLoadedEvent::class => 'onPageLoadedEvent',
        ];
    }

    public function onPageLoadedEvent(NavigationPageLoadedEvent $event) {

        $navigationId = $event->getPage()->getNavigationId();

        $criteria = new Criteria();
        $criteria->setTitle('cms::product-listing');

        $listing = $this->listingRoute
                ->load($navigationId, $event->getRequest(), $event->getSalesChannelContext(), $criteria)
                ->getResult();

        $articleCountStruct = new ArticleCountStruct($listing->getTotal());
        $event->getSalesChannelContext()->addExtensions(['product-count-in-category' => $articleCountStruct]);
    }

}
