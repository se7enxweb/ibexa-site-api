<?php

declare(strict_types=1);

namespace Netgen\Bundle\IbexaSiteApiBundle\View\Redirect;

use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Netgen\Bundle\IbexaSiteApiBundle\NamedObject\Provider;
use Netgen\Bundle\IbexaSiteApiBundle\Traits\LanguageExpressionEvaluatorTrait;
use Netgen\Bundle\IbexaSiteApiBundle\View\ContentView;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class ParameterProcessor
{
    private ExpressionLanguage $expressionLanguage;
    private ConfigResolverInterface $configResolver;
    private Provider $namedObjectProvider;
    use LanguageExpressionEvaluatorTrait;

    public function __construct(ExpressionLanguage $expressionLanguage, ConfigResolverInterface $configResolver, Provider $namedObjectProvider)
    {
        /**
         * @readonly
         */
        $this->expressionLanguage = $expressionLanguage;
        /**
         * @readonly
         */
        $this->configResolver = $configResolver;
        /**
         * @readonly
         */
        $this->namedObjectProvider = $namedObjectProvider;
    }

    /**
     * Return given $value processed with ExpressionLanguage if needed.
     *
     * Parameter $view is used to provide values for evaluation.
     * @param mixed $value
     * @return mixed
     */
    public function process($value, ContentView $view)
    {
        return $this->evaluate(
            $value,
            $this->expressionLanguage,
            [
                'location' => $view->getSiteLocation(),
                'content' => $view->getSiteContent(),
                'configResolver' => $this->configResolver,
                'namedObject' => $this->namedObjectProvider,
            ],
        );
    }
}
