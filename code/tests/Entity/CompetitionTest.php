<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Competition;
use App\Entity\Event;
use App\Entity\Sport;
use App\Entity\SportType;
use App\Tests\GeneralTestMethod;
use DateTime;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CompetitionTest extends KernelTestCase
{
    private Competition $competition;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->competition = new Competition();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->competition, $this->competition);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidNameProvider(string $validName): void
    {
        $this->competition->setName($validName);

        $violationList = $this->validator->validate($this->competition, null, ['newCompetition', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("name", $violationList);
        $obtainedValue = $this->competition->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->competition->setName($invalidName);

        $violationList = $this->validator->validate($this->competition, null, ['newCompetition', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("name", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validCompetitionProvider */
    public function testAddValidCompetition(Competition $validCompetition): void
    {
        $this->assertNotContains(
            $validCompetition,
            $this->competition->getCompetitionsList()
        );

        $this->competition->addCompetitionToList($validCompetition);

        $violationList = $this->validator->validate(
            $this->competition,
            null,
            ['newCompetition', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "competition",
            $violationList
        );

        $this->assertSame(
            $this->competition,
            $validCompetition->getParentCompetition()
        );
        $this->assertContains(
            $validCompetition,
            $this->competition->getCompetitionsList()
        );
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidCompetitionProvider */
    public function testAddInvalidCompetition(Competition $invalidCompetition): void
    {
        $this->assertNotContains(
            $invalidCompetition,
            $this->competition->getCompetitionsList()
        );

        $this->competition->addCompetitionToList($invalidCompetition);

        $violationList = $this->validator->validate(
            $this->competition,
            null,
            ['newCompetition', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "competitionsList",
            $violationList
        );

        $this->assertSame(
            $this->competition,
            $invalidCompetition->getParentCompetition()
        );
        $this->assertContains(
            $invalidCompetition,
            $this->competition->getCompetitionsList()
        );
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validCompetitionProvider */
    public function testRemoveCompetition(Competition $validCompetition): void
    {
        $this->competition->addCompetitionToList($validCompetition);
        $this->assertContains($validCompetition, $this->competition->getCompetitionsList());

        $this->assertSame(
            $this->competition,
            $validCompetition->getParentCompetition()
        );

        $this->competition->removeCompetitionFromList($validCompetition);

        $violationList = $this->validator->validate(
            $this->competition,
            null,
            ['newCompetition', 'Default']
        );

        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "competitionsList",
            $violationList
        );

        $this->assertNotInstanceOf(
            Competition::class,
            $validCompetition->getParentCompetition()
        );
        $this->assertNotSame(
            $this->competition,
            $validCompetition->getParentCompetition()
        );
        $this->assertNotContains(
            $validCompetition,
            $this->competition->getCompetitionsList()
        );
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider validEventProvider */
    public function testAddValidEvent(Event $validEvent): void
    {
        $this->assertNotContains(
            $validEvent,
            $this->competition->getEventsList()
        );
        $this->competition->addEventToList($validEvent);

        $violationList = $this->validator->validate(
            $this->competition,
            null,
            ['newCompetition', 'newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "eventsList",
            $violationList
        );

        $this->assertContains($validEvent, $this->competition->getEventsList());
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidEventProvider */
    public function testAddInvalidEvent(Event $invalidEvent): void
    {
        $this->assertNotContains(
            $invalidEvent,
            $this->competition->getEventsList()
        );
        $this->competition->addEventToList($invalidEvent);

        $violationList = $this->validator->validate(
            $this->competition,
            null,
            ['newCompetition', 'newEvent', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "event",
            $violationList
        );

        $this->assertContains($invalidEvent, $this->competition->getEventsList());
        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validEventProvider */
    public function testRemoveEvent(Event $event): void
    {
        $this->competition->addEventToList($event);
        $this->assertContains($event, $this->competition->getEventsList());

        $this->competition->removeEventFromList($event);

        $violationList = $this->validator->validate(
            $this->competition,
            null,
            ['newEvent', 'newCompetitor', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "competitorsList",
            $violationList
        );

        $this->assertNotContains($event, $this->competition->getEventsList());
        $this->assertFalse($violationOnAttribute);
    }




    /**
     * @TODO Add test for:
     *                    - removeCompetitionFromList()
     *                    - getEventsList()
     *                    - addEventToList()
     *                    - removeEventFromList()
     */

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> */
    public function validNameProvider(): Generator
    {
        yield ["2040 OG"];
        yield ["Ligue 1"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidNameProvider(): Generator
    {
        yield [""];
        yield [" "];
    }

    /** @return Generator<array<int, Competition>> */
    public function validCompetitionProvider(): Generator
    {
        yield [
            (new Competition())
                ->setName("Valid"),
        ];
    }

    /** @return Generator<array<int, Competition>> */
    public function invalidCompetitionProvider(): Generator
    {
        yield [(new Competition())];
    }

    /** @return Generator<array<int, Event>> */
    public function validEventProvider(): Generator
    {
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
    }

    /** @return Generator<array<int, Event>> */
    public function invalidEventProvider(): Generator
    {
        yield [
            (new Event())
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setResult("Valid")
        ];
        yield [
            (new Event())
                ->setName("Valid")
                ->setEventDate(new DateTime())
                ->setLocation("Valid")
                ->setCountryCode("FR")
                ->setTimeZone("Europe/Paris")
                ->setDescription("Location")
                ->setSport(
                    (new Sport())
                        ->setName("Valid")
                        ->setDescription("Valid")
                        ->setSportType(
                            (new SportType())
                                ->setName("Valid")
                                ->setDescription("Valid")
                        )
                )
        ];
    }
}
