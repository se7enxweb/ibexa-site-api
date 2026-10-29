<?php

declare(strict_types=1);

namespace Netgen\Bundle\IbexaSiteApiBundle\Templating\Twig\Extension;

use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult;
use Netgen\Bundle\IbexaSiteApiBundle\QueryType\QueryDefinitionCollection;
use Netgen\Bundle\IbexaSiteApiBundle\QueryType\QueryExecutor;
use Netgen\Bundle\IbexaSiteApiBundle\View\ContentView;
use Pagerfanta\Pagerfanta;
use Twig\Error\RuntimeError;

use function sprintf;

/**
 * Twig extension runtime for executing queries from the QueryDefinitionCollection injected
 * into the template.
 */
class QueryRuntime
{
    private QueryExecutor $queryExecutor;
    public function __construct(QueryExecutor $queryExecutor)
    {
        /**
         * @readonly
         */
        $this->queryExecutor = $queryExecutor;
    }

    /**
     * @param mixed $context
     */
    public function executeQuery($context, string $name): Pagerfanta
    {
        return $this->queryExecutor->execute(
            $this->getQueryDefinitionCollection($context)->get($name),
        );
    }

    /**
     * @param mixed $context
     */
    public function sudoExecuteQuery($context, string $name): Pagerfanta
    {
        return $this->queryExecutor->sudoExecute(
            $this->getQueryDefinitionCollection($context)->get($name),
        );
    }

    /**
     * @param mixed $context
     */
    public function executeRawQuery($context, string $name): SearchResult
    {
        return $this->queryExecutor->executeRaw(
            $this->getQueryDefinitionCollection($context)->get($name),
        );
    }

    /**
     * @param mixed $context
     */
    public function sudoExecuteRawQuery($context, string $name): SearchResult
    {
        return $this->queryExecutor->sudoExecuteRaw(
            $this->getQueryDefinitionCollection($context)->get($name),
        );
    }

    /**
     * Returns the QueryDefinitionCollection variable from the given $context.
     *
     * @throws \Twig\Error\RuntimeError
     * @param mixed $context
     */
    private function getQueryDefinitionCollection($context): QueryDefinitionCollection
    {
        if (!isset($context[ContentView::QUERY_DEFINITION_COLLECTION_NAME])) {
            throw new RuntimeError(
                sprintf(
                    "Could not find QueryDefinitionCollection variable '%s'",
                    ContentView::QUERY_DEFINITION_COLLECTION_NAME,
                ),
            );
        }
        return $context[ContentView::QUERY_DEFINITION_COLLECTION_NAME];
    }
}
