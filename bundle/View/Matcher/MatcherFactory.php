<?php

declare(strict_types=1);

namespace Netgen\Bundle\IbexaSiteApiBundle\View\Matcher;

use Ibexa\Bundle\Core\Matcher\ViewMatcherRegistry;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Core\MVC\Symfony\Matcher\ClassNameMatcherFactory;
use Ibexa\Core\MVC\Symfony\Matcher\ViewMatcherInterface;
use Ibexa\Core\MVC\Symfony\View\View;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use function mb_substr;
use function str_starts_with;

class MatcherFactory extends ClassNameMatcherFactory
{
    private ?ViewMatcherRegistry $viewMatcherRegistry;
    private ConfigResolverInterface $configResolver;
    private string $parameterName;
    private ?string $namespace = null;
    private ?string $scope = null;
    use ContainerAwareTrait;

    public function __construct(
        Repository $repository,
        string $relativeNamespace,
        ?ViewMatcherRegistry $viewMatcherRegistry,
        ConfigResolverInterface $configResolver,
        string $parameterName,
        ?string $namespace = null,
        ?string $scope = null
    ) {
        /**
         * @readonly
         */
        $this->viewMatcherRegistry = $viewMatcherRegistry;
        /**
         * @readonly
         */
        $this->configResolver = $configResolver;
        /**
         * @readonly
         */
        $this->parameterName = $parameterName;
        /**
         * @readonly
         */
        $this->namespace = $namespace;
        /**
         * @readonly
         */
        $this->scope = $scope;
        parent::__construct($repository, $relativeNamespace);
    }

    public function match(View $view): ?array
    {
        $matchConfig = $this->configResolver->getParameter($this->parameterName, $this->namespace, $this->scope);
        $this->setMatchConfig($matchConfig);

        return parent::match($view);
    }

    /**
     * @param string $matcherIdentifier
     */
    protected function getMatcher($matcherIdentifier): ViewMatcherInterface
    {
        if ($this->viewMatcherRegistry !== null && strncmp($matcherIdentifier, '@', strlen('@')) === 0) {
            return $this->viewMatcherRegistry->getMatcher(mb_substr($matcherIdentifier, 1));
        }

        if ($this->container->has($matcherIdentifier)) {
            /** @var \Ibexa\Core\MVC\Symfony\Matcher\ViewMatcherInterface $matcher */
            $matcher = $this->container->get($matcherIdentifier);

            return $matcher;
        }

        return parent::getMatcher($matcherIdentifier);
    }
}
