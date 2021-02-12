<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Event;
use App\Entity\Odds;
use App\Tests\GeneralTestMethod;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class EventTest extends KernelTestCase
{
    private Event $event;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->event = new Event();

        $this->validator = GeneralTestMethod::getValidator();
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidName(string $validName): void
    {
        $this->event->setName($validName);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );
        $obtainedValue = $this->event->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->event->setName($invalidName);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider dateProvider */
    public function testSetValidEventDate(DateTimeInterface $validEventDate): void
    {
        $this->event->setEventDate($validEventDate);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "date",
            $violationList
        );
        $obtainedValue = $this->event->getEventDate();

        $this->assertSame($validEventDate, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider validLocationProvider */
    public function testSetValidLocation(string $validLocation): void
    {
        $this->event->setLocation($validLocation);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "location",
            $violationList
        );
        $obtainedValue = $this->event->getLocation();

        $this->assertSame($validLocation, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidLocationProvider */
    public function testSetInvalidLocation(string $invalidLocation): void
    {
        $this->event->setLocation($invalidLocation);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "location",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validCountryCodeProvider */
    public function testSetValidCountryCode(string $validCountryCode): void
    {
        $this->event->setCountryCode($validCountryCode);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "countryCode",
            $violationList
        );
        $obtainedValue = $this->event->getCountryCode();

        $this->assertSame($validCountryCode, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidCountryCodeProvider */
    public function testSetInvalidCountryCode(string $invalidCountryCode): void
    {
        $this->event->setCountryCode($invalidCountryCode);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "countryCode",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validTimeZoneProvider */
    public function testSetValidTimeZone(string $validTimeZone): void
    {
        $this->event->setTimeZone($validTimeZone);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "timeZone",
            $violationList
        );
        $obtainedValue = $this->event->getTimeZone();

        $this->assertSame($validTimeZone, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidTimeZoneProvider */
    public function testSetInvalidTimeZone(string $invalidTimeZone): void
    {
        $this->event->setTimeZone($invalidTimeZone);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "timeZone",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validDescriptionProvider */
    public function testSetValidDescription(string $validDescription): void
    {
        $this->event->setDescription($validDescription);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );
        $obtainedValue = $this->event->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $invalidDescription): void
    {
        $this->event->setDescription($invalidDescription);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validResultProvider */
    public function testSetValidResult(string $validResult): void
    {
        $this->event->setResult($validResult);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "result",
            $violationList
        );
        $obtainedValue = $this->event->getResult();

        $this->assertSame($validResult, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidResultProvider */
    public function testSetInvalidResult(string $invalidResult): void
    {
        $this->event->setResult($invalidResult);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "result",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /**
     * @dataProvider validOddsListProvider
     * @param Collection<int|null, Odds|null> $validOddsList
     */
    public function testSetValidOddsList(Collection $validOddsList): void
    {
        $this->event->setOddsList($validOddsList);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'newOdds', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "oddsList",
            $violationList
        );
        $obtainedValue = $this->event->getOddsList();

        $this->assertSame($validOddsList, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /**
     * @dataProvider invalidOddsListProvider
     * @param Collection<int|null, Odds|null> $invalidOddsList
     */
    public function testSetInvalidOddsList(Collection $invalidOddsList): void
    {
        $this->event->setOddsList($invalidOddsList);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'newOdds', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "oddsList",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validOddsProvider */
    public function testAddValidOdds(Odds $validOdds): void
    {
        $this->assertNotContains($validOdds, $this->event->getOddsList());
        $this->event->addOddsToList($validOdds);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'newOdds', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "oddsList",
            $violationList
        );

        $this->assertContains($validOdds, $this->event->getOddsList());
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidOddsProvider */
    public function testAddInvalidOdds(Odds $invalidOdds): void
    {
        $this->assertNotContains($invalidOdds, $this->event->getOddsList());
        $this->event->addOddsToList($invalidOdds);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'newOdds', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "oddsList",
            $violationList
        );

        $this->assertContains($invalidOdds, $this->event->getOddsList());
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validOddsProvider */
    public function testRemoveOdds(Odds $validOdds): void
    {
        $this->event->addOddsToList($validOdds);
        $this->assertContains($validOdds, $this->event->getOddsList());

        $this->event->removeOddsFromList($validOdds);

        $violationList = $this->validator->validate(
            $this->event,
            null,
            ['newEvent', 'newOdds', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "oddsList",
            $violationList
        );

        $this->assertNotContains($validOdds, $this->event->getOddsList());
        $this->assertFalse($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> */
    public function validNameProvider(): Generator
    {
        yield ["Paris - Marseille"];
        yield ["France - Italie"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidNameProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["  "];
    }

    /** @return Generator<array<int, DateTimeInterface>> */
    public function dateProvider(): Generator
    {
        yield [(new DateTime())];
        yield [(new DateTimeImmutable())];
    }

    /** @return Generator<array<int, string>> */
    public function validLocationProvider(): Generator
    {
        yield ["Valid location here"];
        yield ["Another"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidLocationProvider(): Generator
    {
        yield [""];
        yield ["  "];
        yield ["   "];
    }

    /** @return Generator<array<int, string>> */
    public function validCountryCodeProvider(): Generator
    {
        yield ["FR"];
        yield ["GB"];
        yield ["US"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidCountryCodeProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["   "];
    }

    /** @return Generator<array<int, string>> */
    public function validTimeZoneProvider(): Generator
    {
        yield ["Europe/Paris"];
        yield ["Europe/London"];
        yield ["America/Los_Angeles"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidTimeZoneProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["   "];
    }

    /** @return Generator<array<int, string>> */
    public function validDescriptionProvider(): Generator
    {
        yield ["Valid description"];
        yield ["Another valid description"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidDescriptionProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["  "];
    }

    /** @return Generator<array<int, string>> */
    public function validResultProvider(): Generator
    {
        yield ["Paris 2 - Marseille 2"];
        yield ["Paris 1 - Marseille 0"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidResultProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["  "];
    }

    /** @return Generator<array<int, Collection<int, Odds>>> */
    public function validOddsListProvider(): Generator
    {
        yield [
            new ArrayCollection(
                [
                    (new Odds())
                        ->setDescription("Valid Description")
                        ->setOddsValue(1.55)
                        ->setWinning(null),
                    (new Odds())
                        ->setDescription("Valid Description")
                        ->setOddsValue(3.75)
                        ->setWinning(false)
                ]
            )
        ];
        yield [
            new ArrayCollection(
                [
                    (new Odds())
                        ->setDescription("Valid Description")
                        ->setOddsValue(1.55)
                        ->setWinning(null)
                ]
            )
        ];
    }

    /** @return Generator<array<int, Collection<int, Odds>>> */
    public function invalidOddsListProvider(): Generator
    {
        yield [
            new ArrayCollection(
                [
                    (new Odds())
                        ->setDescription("Valid Description")
                ]
            )
        ];
        yield [
            new ArrayCollection(
                [
                    (new Odds())
                        ->setDescription("Valid Description")
                        ->setWinning(null)
                ]
            )
        ];
    }

    /** @return Generator<array<int, Odds>> */
    public function validOddsProvider(): Generator
    {
        yield [
            (new Odds())
                ->setDescription("Valid Description")
                ->setOddsValue(1.55)
                ->setWinning(null)
        ];
        yield [
            (new Odds())
                ->setDescription("Valid Description")
                ->setOddsValue(3.75)
                ->setWinning(false)
        ];
    }

    /** @return Generator<array<int, Odds>> */
    public function invalidOddsProvider(): Generator
    {
        yield [
            (new Odds())
                ->setDescription("Valid Description")
                ->setWinning(null)
        ];
        yield [
            (new Odds())
                ->setWinning(false)
        ];
    }
}
