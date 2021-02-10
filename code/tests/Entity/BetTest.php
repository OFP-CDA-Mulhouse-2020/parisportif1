<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Bet;
use App\Entity\Odds;
use App\Entity\User;
use App\Tests\GeneralTestMethod;
use DateTime;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BetTest extends KernelTestCase
{
    private Bet $bet;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->bet = new Bet();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->bet, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validAmountProvider */
    public function testSetValidAmount(int $validAmount): void
    {
        $this->bet->setAmount($validAmount);

        $violationList = $this->validator->validate($this->bet, null, ['newBet', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("amount", $violationList);
        $obtainedValue = $this->bet->getAmount();

        $this->assertSame($validAmount, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidAmountProvider */
    public function testSetInvalidAmount(int $invalidAmount): void
    {
        $this->bet->setAmount($invalidAmount);

        $violationList = $this->validator->validate($this->bet, null, ['newBet', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("amount", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validOddsWhenPayedProvider */
    public function testSetValidOddsWhenPayed(float $validOddsWhenPayed): void
    {
        $this->bet->setOddsWhenPayed($validOddsWhenPayed);

        $violationList = $this->validator->validate($this->bet, null, ['newBet', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("oddsWhenPayed", $violationList);
        $obtainedValue = $this->bet->getOddsWhenPayed();

        $this->assertSame($validOddsWhenPayed, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidOddsWhenPayedProvider */
    public function testSetInvalidOddsWhenPayed(float $invalidOddsWhenPayed): void
    {
        $this->bet->setOddsWhenPayed($invalidOddsWhenPayed);

        $violationList = $this->validator->validate($this->bet, null, ['newBet', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("oddsWhenPayed", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validOddsReferenceProvider */
    public function testSetValidOddsReference(Odds $validOddsReference): void
    {
        $this->bet->setOddsReference($validOddsReference);

        $violationList = $this->validator->validate($this->bet, null, ['newBet', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("oddsReference", $violationList);
        $obtainedValue = $this->bet->getOddsReference();

        $this->assertSame($validOddsReference, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidOddsReferenceProvider */
    public function testSetInvalidOddsReference(Odds $invalidOddsReference): void
    {
        $this->bet->setOddsReference($invalidOddsReference);

        $violationList = $this->validator->validate($this->bet, null, ['newBet', 'newOdds', 'updateOdds', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("oddsReference", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, int>> * */
    public function validAmountProvider(): Generator
    {
        yield [10];
        yield [5000];
    }

    /** @return Generator<array<int, int>> * */
    public function invalidAmountProvider(): Generator
    {
        yield [0];
        yield [9];
        yield [-50];
    }

    /** @return Generator<array<int, float>> * */
    public function validOddsWhenPayedProvider(): Generator
    {
        yield [1.06];
        yield [2.61];
        yield [7.54];
    }

    /** @return Generator<array<int, float>> * */
    public function invalidOddsWhenPayedProvider(): Generator
    {
        yield [1.0];
        yield [0.54];
        yield [-5.56];
    }

    /** @dataProvider validUserProvider */
    public function testSetValidUser(User $validUser): void
    {
        $this->bet->setUser($validUser);

        $violationList = $this->validator->validate(
            $this->bet,
            null,
            ['newBet', 'updateUser', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn("user", $violationList);
        $obtainedValue = $this->bet->getUser();

        $this->assertSame($validUser, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidUserProvider */
    public function testSetInvalidUser(User $invalidUser): void
    {
        $this->bet->setUser($invalidUser);

        $violationList = $this->validator->validate(
            $this->bet,
            null,
            ['newBet', 'updateUser', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn("user", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @TODO Add test once getResolved and setResolved got refactored {@see Bet::getResolved()} */

    /** @return Generator<array<int, Odds>> * */
    public function validOddsReferenceProvider(): Generator
    {
        yield [
            (new Odds())
                ->setDescription("This is a description")
                ->setWinning(null)
                ->setOddsValue(1.75)
        ];

        yield [
            (new Odds())
                ->setDescription("This is a description")
                ->setWinning(true)
                ->setOddsValue(1.25)
        ];

        yield [
            (new Odds())
                ->setDescription("This is a description")
                ->setWinning(false)
                ->setOddsValue(4.55)
        ];
    }

    /** @return Generator<array<int, Odds>> * */
    public function invalidOddsReferenceProvider(): Generator
    {
        yield [
            (new Odds())
                ->setOddsValue(-1.75)
        ];

        yield [
            (new Odds())
                ->setOddsValue(0.90)
        ];
    }

    /** @return Generator<array<int, User>> * */
    public function validUserProvider(): Generator
    {
        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = GeneralTestMethod::getKernel()->getContainer()->get('security.password_encoder');

        yield [
            (new User())
                ->setEmail('valid@email.com')
                ->setPassword($encoder->encodePassword(new User(), 'password'))
                ->setLastname('Tolkien')
                ->setFirstname('John')
                ->setBirthdate(new DateTime('1892-09-02'))
                ->setCountryCode('GB')
                ->setTimeZone('Europe/London')
        ];

        yield [
            (new User())
                ->setEmail('secondValid@email.com')
                ->setPassword($encoder->encodePassword(new User(), 'password'))
                ->setLastname('Ritchie')
                ->setFirstname('Dennis')
                ->setBirthdate(new DateTime('1941-09-09'))
                ->setCountryCode('US')
                ->setTimeZone('America/Los_Angeles')
        ];
    }

    /** @return Generator<array<int, User>> * */
    public function invalidUserProvider(): Generator
    {
        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = GeneralTestMethod::getKernel()->getContainer()->get('security.password_encoder');

        yield [
            (new User())
                ->setEmail('invalidate.com')
                ->setPassword($encoder->encodePassword(new User(), 'password'))
                ->setLastname('Tolkien')
                ->setFirstname('John')
                ->setBirthdate(new DateTime('1892-09-02'))
                ->setCountryCode('EN')
                ->setTimeZone('Europe/London')
        ];

        yield [
            (new User())
                ->setEmail('secondValid@email.com')
        ];
    }
}
