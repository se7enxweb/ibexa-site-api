<?php

declare(strict_types=1);

namespace Netgen\IbexaSiteApi\Core\Site;

use Ibexa\Contracts\Core\Repository\Exceptions\PropertyNotFoundException;
use Ibexa\Contracts\Core\Repository\Exceptions\PropertyReadOnlyException;
use Netgen\IbexaSiteApi\API\Settings as BaseSettings;

/**
 * @internal
 *
 * Hint against API abstract class instead of this service:
 *
 * @see \Netgen\IbexaSiteApi\API\Settings
 */
final class Settings extends BaseSettings
{
    /**
     * @var string[]
     */
    private array $prioritizedLanguages;
    private bool $useAlwaysAvailable;
    private int $rootLocationId;
    private bool $showHiddenItems;
    private bool $failOnMissingField;
    /**
     * @param string[] $prioritizedLanguages
     *
     * @noinspection PhpPropertyCanBeReadonlyInspection
     */
    public function __construct(array $prioritizedLanguages, bool $useAlwaysAvailable, int $rootLocationId, bool $showHiddenItems, bool $failOnMissingField)
    {
        $this->prioritizedLanguages = $prioritizedLanguages;
        /**
         * @readonly
         */
        $this->useAlwaysAvailable = $useAlwaysAvailable;
        /**
         * @readonly
         */
        $this->rootLocationId = $rootLocationId;
        /**
         * @readonly
         */
        $this->showHiddenItems = $showHiddenItems;
        /**
         * @readonly
         */
        $this->failOnMissingField = $failOnMissingField;
    }

    /**
     * @return bool|int|string[]
     *
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\PropertyNotFoundException
     */
    public function __get(string $property)
    {
        switch ($property) {
            case 'prioritizedLanguages':
                return $this->prioritizedLanguages;
            case 'useAlwaysAvailable':
                return $this->useAlwaysAvailable;
            case 'rootLocationId':
                return $this->rootLocationId;
            case 'showHiddenItems':
                return $this->showHiddenItems;
            case 'failOnMissingField':
                return $this->failOnMissingField;
            default:
                throw new PropertyNotFoundException($property, self::class);
        }
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\PropertyReadOnlyException
     * @param mixed $value
     */
    public function __set(string $property, $value): void
    {
        throw new PropertyReadOnlyException($property, self::class);
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\PropertyNotFoundException
     */
    public function __isset(string $property): bool
    {
        switch ($property) {
            case 'prioritizedLanguages':
            case 'useAlwaysAvailable':
            case 'rootLocationId':
            case 'showHiddenItems':
            case 'failOnMissingField':
                return true;
            default:
                throw new PropertyNotFoundException($property, self::class);
        }
    }
}
