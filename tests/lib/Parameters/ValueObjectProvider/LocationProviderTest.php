<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\SiteApi\Tests\Parameters\ValueObjectProvider;

use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Core\Base\Exceptions\NotFoundException;
use Netgen\IbexaSiteApi\API\LoadService;
use Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider\LocationProvider;
use Netgen\Layouts\Ibexa\SiteApi\Tests\Stubs\Location;
use Netgen\Layouts\Parameters\ValueObjectProviderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LocationProviderTest extends TestCase
{
    private MockObject $repositoryMock;

    private MockObject $loadServiceMock;

    private ValueObjectProviderInterface $valueObjectProvider;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(Repository::class);
        $this->loadServiceMock = $this->createMock(LoadService::class);

        $this->repositoryMock
            ->expects(self::any())
            ->method('sudo')
            ->with(self::anything())
            ->willReturnCallback(
                fn (callable $callback) => $callback($this->repositoryMock),
            );

        $this->valueObjectProvider = new LocationProvider(
            $this->repositoryMock,
            $this->loadServiceMock,
        );
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider\LocationProvider::__construct
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider\LocationProvider::getValueObject
     */
    public function testGetValueObject(): void
    {
        $location = new Location();

        $this->loadServiceMock
            ->expects(self::any())
            ->method('loadLocation')
            ->with(self::identicalTo(42))
            ->willReturn($location);

        self::assertSame($location, $this->valueObjectProvider->getValueObject(42));
    }

    /**
     * @covers \Netgen\Layouts\Ibexa\SiteApi\Parameters\ValueObjectProvider\LocationProvider::getValueObject
     */
    public function testGetValueObjectWithNonExistentLocation(): void
    {
        $this->loadServiceMock
            ->expects(self::any())
            ->method('loadLocation')
            ->with(self::identicalTo(42))
            ->willThrowException(new NotFoundException('location', 42));

        self::assertNull($this->valueObjectProvider->getValueObject(42));
    }
}
