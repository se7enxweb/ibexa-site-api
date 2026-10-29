<?php

declare(strict_types=1);

namespace Netgen\Bundle\IbexaSiteApiBundle\View\LocationResolver;

use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Core\Helper\ContentInfoLocationLoader;
use Netgen\Bundle\IbexaSiteApiBundle\View\LocationResolver;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\IbexaSiteApi\API\Values\Content;
use Netgen\IbexaSiteApi\API\Values\Location;

class CoreAdapterResolver extends LocationResolver
{
    public function __construct(
        /**
         * @readonly
         */
        private Repository $repository,
        /**
         * @readonly
         */
        private LoadService $loadService,
        /**
         * @readonly
         */
        private ContentInfoLocationLoader $coreLoader,
    ) {}

    public function getLocation(Content $content): Location
    {
        $repoLocation = $this->coreLoader->loadLocation($content->contentInfo->innerContentInfo);

        return $this->repository->sudo(
            fn (Repository $repository): Location => $this->loadService->loadLocation($repoLocation->id),
        );
    }
}
