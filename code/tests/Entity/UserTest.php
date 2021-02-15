<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Wallet;
use App\Entity\WalletPayment;
use App\Tests\GeneralTestMethod;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserTest extends KernelTestCase
{
    private User $user;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->user = new User();

        $this->validator = GeneralTestMethod::getValidator();
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validEmailProvider */
    public function testSetValidEmail(string $validEmail): void
    {
        $this->user->setEmail($validEmail);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("email", $violationList);
        $obtainedValue = $this->user->getEmail();

        $this->assertSame($validEmail, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidEmailProvider */
    public function testSetInvalidEmail(string $invalidEmail): void
    {
        $this->user->setEmail($invalidEmail);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("email", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validLastNameProvider */
    public function testSetValidLastName(string $validLastName): void
    {
        $this->user->setLastname($validLastName);

        $violationList = $this->validator->validate($this->user);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("lastname", $violationList);
        $obtainedValue = $this->user->getLastname();

        $this->assertSame($validLastName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidLastNameProvider */
    public function testSetInvalidLastName(string $invalidLastName): void
    {
        $this->user->setLastname($invalidLastName);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("lastname", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validFirstNameProvider */
    public function testSetValidFirstName(string $validFirstName): void
    {
        $this->user->setFirstname($validFirstName);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("firstname", $violationList);
        $obtainedValue = $this->user->getFirstname();

        $this->assertSame($validFirstName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidFirstNameProvider */
    public function testSetInvalidFirstName(string $invalidFirstName): void
    {
        $this->user->setFirstname($invalidFirstName);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("firstname", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validBirthDateProvider */
    public function testSetValidBirthDate(DateTimeInterface $validDate): void
    {
        $this->user->setBirthdate($validDate);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("birthdate", $violationList);
        $obtainedValue = $this->user->getBirthdate();

        $this->assertSame($validDate, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidBirthDateProvider */
    public function testSetInvalidBirthDate(DateTimeInterface $invalidBirthDate): void
    {
        $this->user->setBirthdate($invalidBirthDate);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("birthdate", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validCountryCodeProvider */
    public function testSetValidCountryCode(string $validCountryCode): void
    {
        $this->user->setCountryCode($validCountryCode);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("countryCode", $violationList);
        $obtainedValue = $this->user->getCountryCode();

        $this->assertSame($validCountryCode, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidCountryCodeProvider */
    public function testSetInvalidCountryCode(string $invalidCountryCode): void
    {
        $this->user->setCountryCode($invalidCountryCode);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("countryCode", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validTimeZoneProvider */
    public function testSetValidTimeZone(string $validTimeZone): void
    {
        $this->user->setTimeZone($validTimeZone);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("timeZone", $violationList);
        $obtainedValue = $this->user->getTimeZone();

        $this->assertSame($validTimeZone, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidTimeZoneProvider */
    public function testSetInvalidTimeZone(string $invalidTimeZone): void
    {
        $this->user->setTimeZone($invalidTimeZone);

        $violationList = $this->validator->validate($this->user, null, ['registerUser', 'updateUser', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("timeZone", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validWalletProvider */
    public function testSetValidWallet(Wallet $validWallet): void
    {
        $this->user->setWallet($validWallet);

        $violationList = $this->validator->validate(
            $this->user,
            null,
            [
                'registerUser',
                'updateWalletPaymentHistory',
                'changeWalletBalance',
                'Default'
            ]
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn("wallet", $violationList);
        $obtainedValue = $this->user->getWallet();

        $this->assertSame($validWallet, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidWalletProvider */
    public function testSetInvalidWallet(Wallet $invalidWallet): void
    {
        $this->user->setWallet($invalidWallet);

        $violationList = $this->validator->validate(
            $this->user,
            null,
            [
                'registerUser',
                'updateWalletPaymentHistory',
                'changeWalletBalance',
                'Default'
            ]
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn("wallet", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> */
    public function validEmailProvider(): Generator
    {
        yield ["doe.j@codeur.online"];
        yield ["john@doe.com"];
    }

    /** @return Generator<array<int, string>> * */
    public function invalidEmailProvider(): Generator
    {
        yield [""];
        yield ["doe.j@@codeuronline"];
        yield ["johndoe.com"];
    }

    /** @return Generator<array<int, string>> */
    public function validLastNameProvider(): Generator
    {
        yield ["Dupont"];
        yield ["Smith"];
        yield ["O"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidLastNameProvider(): Generator
    {
        yield [""];
        yield ["Favo*"];
        yield ["W@"];
    }

    /** @return Generator<array<int, string>> * */
    public function validFirstNameProvider(): Generator
    {
        yield ['John'];
        yield ['Edouard'];
        yield ['El\'Rob'];
    }

    /** @return Generator<array<int, string>> * */
    public function invalidFirstNameProvider(): Generator
    {
        yield [''];
        yield ['Edo@uard'];
        yield ['El+Rob'];
    }

    /** @return Generator<array<int, DateTimeInterface>> * */
    public function validBirthDateProvider(): Generator
    {
        yield [new DateTime("now - 18 years")];
        yield [new DateTime("now - 21 years")];
    }

    /** @return Generator<array<int, DateTimeInterface>> * */
    public function invalidBirthDateProvider(): Generator
    {
        yield [(new DateTime("now - 18 years"))->add(new DateInterval('PT1H'))];
        yield [(new DateTime("now - 18 years"))->add(new DateInterval('PT5M'))];
        yield [new DateTime("now - 15 years")];
    }

    /** @return Generator<array<int, string>> * */
    public function validCountryCodeProvider(): Generator
    {
        yield ["FR"];
        yield ["BE"];
        yield ["CH"];
    }

    /** @return Generator<array<int, string>> * */
    public function invalidCountryCodeProvider(): Generator
    {
        yield [""];
        yield ["NOT VALID LEL"];
    }

    /** @return Generator<array<int, string>> * */
    public function validTimeZoneProvider(): Generator
    {
        yield ['Europe/Paris'];
        yield ['Europe/Brussels'];
        yield ['Europe/Oslo'];
    }

    /** @return Generator<array<int, string>> * */
    public function invalidTimeZoneProvider(): Generator
    {
        yield [""];
        yield ["NOT A TIMEZONE"];
        yield ["EuropeParis"];
    }

    /** @return Generator<array<int, Wallet>> * */
    public function validWalletProvider(): Generator
    {
        yield [(new Wallet())->setBalance(0)];
        yield [(new Wallet())->setBalance(5000)];
    }

    /** @return Generator<array<int, Wallet>> * */
    public function invalidWalletProvider(): Generator
    {
        yield [new Wallet()];
        yield [(new Wallet())->setBalance(-5000)];
        yield [(new Wallet())->addWalletPaymentToHistory(new WalletPayment())];
    }
}
