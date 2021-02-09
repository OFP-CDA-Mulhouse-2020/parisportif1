<?php

namespace App\Tests;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class GeneralTestMethod extends WebTestCase
{
    public static function getKernel(): KernelInterface
    {
        return self::bootKernel();
    }

    public static function getValidator(): ValidatorInterface
    {
        /** @var ValidatorInterface $validator */
        $validator = self::getKernel()->getContainer()->get('validator');
        return $validator;
    }

    public static function getEntityManager(): ObjectManager
    {
        /** @var ManagerRegistry $managerRepository */
        $managerRepository = self::getKernel()->getContainer()->get('doctrine');
        return $managerRepository->getManager();
    }

    public static function getClient(): KernelBrowser
    {
        return self::createClient();
    }

    /** @param ConstraintViolationListInterface<ConstraintViolationInterface> $violationsList */
    public static function isViolationOn(
        string $testedAttribute,
        ConstraintViolationListInterface $violationsList
    ): bool {
        $violationsCount = count($violationsList);

        for ($i = 0; $i < $violationsCount; $i++) {
            /** TODO When switching to php8 replace strpos() by str_contains() */
            if (strpos($violationsList->get($i)->getPropertyPath(), $testedAttribute) !== false) {
                return true;
            }
        }

        return false;
    }
}
