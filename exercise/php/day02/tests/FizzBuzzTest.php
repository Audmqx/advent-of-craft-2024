<?php

declare(strict_types = 1);

use Games\{FizzBuzz,Mapping};
use QuickCheck\Generator;
use QuickCheck\PHPUnit\PropertyConstraint;
use QuickCheck\Property;


it('fizzBuzz can be extended', function(): void {
	Mapping::add(7,"Whizz");
	$result = FizzBuzz::convert(7);
	expect($result)->toBe("Whizz");

	Mapping::add(11,"Bang");
	$result = FizzBuzz::convert(11);
	expect($result)->toBe("Bang");
});

it('returns the correct representation for given numbers', function ($input, $expectedResult): void {
	$result = FizzBuzz::convert($input);
	expect($result)->toBe($expectedResult);
})->with([
	[1, '1'],
	[67, '67'],
	[82, '82'],
	[3, 'Fizz'],
	[66, 'Fizz'],
	[99, 'Fizz'],
	[5, 'Buzz'],
	[50, 'Buzz'],
	[85, 'Buzz'],
	[15, 'FizzBuzz'],
	[30, 'FizzBuzz'],
	[45, 'FizzBuzz'],
]);

it('returns a valid string for numbers between 1 and 100', function (): void {
	$this->assertThat(Property::forAll(
		[Generator::choose(FizzBuzz::MIN, FizzBuzz::MAX)],
		function ($x) {
			$result = FizzBuzz::convert($x);

			return in_array($result, ['Fizz', 'Buzz', 'FizzBuzz', (string) $x]);
		}
	), PropertyConstraint::check(1000));
});

it('returns null for numbers out of range using property-based testing', function (): void {
	$this->assertThat(Property::forAll(
		[Generator::oneOf(
			Generator::choose(-10000, FizzBuzz::MIN - 1),
			Generator::choose(FizzBuzz::MAX + 1, 10000)
		)],
		function ($x) {
			return FizzBuzz::convert($x) === null;
		}
	), PropertyConstraint::check(1000));
});
