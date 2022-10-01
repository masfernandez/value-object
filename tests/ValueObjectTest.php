<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\ValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints;

class ValueObjectTest extends TestCase
{
    public function testLengthValueCustomConstraints(): void
    {
        $valueObject = new class ('string too length') extends ValueObject {
            /**
             * @return \Symfony\Component\Validator\Constraints\Length[]
             */
            protected static function setConstraints(): array
            {
                return [
                    new Constraints\Length(['min' => 1]),
                ];
            }

            public function value(): void
            {
            }

            public function __toString(): string
            {
                return '';
            }
        };

        $constraints = $valueObject::getConstraints();
        $this->assertIsArray($constraints);
    }
}
