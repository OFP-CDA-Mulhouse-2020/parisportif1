<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TeamTest extends KernelTestCase
{
    private ?Team $team;
    private ?ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->team = new Team();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfTeam(): void
    {
        $this->assertInstanceOf(Team::class, $this->team);
        $this->assertClassHasAttribute("name", Team::class);
        $this->assertClassHasAttribute("description", Team::class);
    }

    /**
     * @dataProvider invalidNameProvider()
     */
    public function testSetInvalidTeamName(string $name)
    {
        $this->team->setName($name);
        $errorsList = $this->validator->validate($this->team);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidNameProvider(): array
    {
        return [
            [""],
            [
                "Amon Rattanakosin Krung Thep Mahanakhon Mahinthara Mahadilok Phop Noppharat Ratchathani " .
                "Ayuthaya Burirom Udomratchaniwet Mahasathan Amon Piman Awatan Sathit Sakkathattiya Witsanukam " .
                "Prasit Bravo Association Amon Rattanakosin Krung Thep Mahanakhon Mahinthara Mahadilok Phop Noppharat " .
                "Ratchathani Ayuthaya Burirom Udomratchaniwet Mahasathan Amon Piman Awatan Sathit Sakkathattiya " .
                "Witsanukam Prasit Bravo Association Football Club"
            ]
        ];
    }

    /**
     * @dataProvider validNameProvider()
     */
    public function testSetValidTeamName(string $name)
    {
        $this->team->setName($name);
        $errorsList = $this->validator->validate($this->team);
        $this->assertEquals(0, count($errorsList));
    }

    public function validNameProvider(): array
    {
        return [
            [
                "Amon Rattanakosin Krung Thep Mahanakhon Mahinthara Mahadilok Phop Noppharat Ratchathani Ayuthaya " .
                "Burirom Udomratchaniwet Mahasathan Amon Piman Awatan Sathit Sakkathattiya Witsanukam Prasit Bravo " .
                "Association Football Club"
            ]
        ];
    }

    /**
     * @dataProvider validDescriptionProvider()
     */
    public function testSetValidTeamDescription(string $description)
    {
        $this->team->setName($description);
        $errorsList = $this->validator->validate($this->team);
        $this->assertEquals(0, count($errorsList));
    }

    public function validDescriptionProvider(): array
    {
        return [
            [
                "Bangkok Bravo FC is a Thai club based in the country's capital. " .
                "Bangkok Bravo FC officially has the longest club name in football at the moment"
            ]
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->team = null;
        $this->validator = null;
    }
}
