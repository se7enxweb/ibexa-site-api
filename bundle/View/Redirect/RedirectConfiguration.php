<?php

declare(strict_types=1);

namespace Netgen\Bundle\IbexaSiteApiBundle\View\Redirect;

final class RedirectConfiguration
{
    /**
     * @var mixed
     */
    private $target;
    private array $targetParameters;
    private bool $permanent;
    private bool $keepRequestMethod;
    private bool $absolute;
    /**
     * @param mixed $target
     */
    public function __construct($target, array $targetParameters, bool $permanent, bool $keepRequestMethod, bool $absolute)
    {
        /**
         * @readonly
         */
        $this->target = $target;
        /**
         * @readonly
         */
        $this->targetParameters = $targetParameters;
        /**
         * @readonly
         */
        $this->permanent = $permanent;
        /**
         * @readonly
         */
        $this->keepRequestMethod = $keepRequestMethod;
        /**
         * @readonly
         */
        $this->absolute = $absolute;
    }

    public static function fromConfigurationArray(array $config): self
    {
        return new self(
            $config['target'],
            $config['target_parameters'],
            $config['permanent'],
            $config['keep_request_method'],
            $config['absolute'],
        );
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    public function getTargetParameters(): array
    {
        return $this->targetParameters;
    }

    public function isPermanent(): bool
    {
        return $this->permanent;
    }

    public function keepRequestMethod(): bool
    {
        return $this->keepRequestMethod;
    }

    public function isAbsolute(): bool
    {
        return $this->absolute;
    }
}
