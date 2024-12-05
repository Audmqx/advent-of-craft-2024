<?php

declare(strict_types = 1);

use Preparation\Gift;
use Preparation\SantaWorkshopService;

const RECOMMENDED_AGE = 'recommendedAge';

beforeEach(function (): void {
	$this->service = new SantaWorkshopService;
});

dataset('fuzzing_inputs_with_attributes', function () {
    foreach (range(1, 100) as $i) {
        yield [
            bin2hex(random_bytes(random_int(1, 30))), 
            random_int(-100, 200) / 10,              
            chr(random_int(0, 255)) . bin2hex(random_bytes(random_int(1, 10))), 
            str_shuffle('abcdefghijklmnopqrstuvwxyz' . bin2hex(random_bytes(random_int(1, 10)))), 
            'recommendedAge', 
            (string)random_int(-100, 100), 
        ];
    }
});



it('performs fuzzing on adding attributes to gifts', function (string $giftName, float $weight, string $color, string $material, string $attributeName, string $attributeValue) {
    try {
        $gift = $this->service->prepareGift($giftName, $weight, $color, $material);

        if ($attributeName === 'recommendedAge' && is_numeric($attributeValue)) {
            $gift->addAttribute($attributeName, $attributeValue);

            expect($gift->recommendedAge())->toBe((int)$attributeValue);
        }
    } catch (Throwable $e) {
        if ($weight > 5.0) {
            expect($e)->toBeInstanceOf(InvalidArgumentException::class);
            expect($e->getMessage())->toBe('Gift is too heavy for Santa\'s sleigh');
        } else {
            echo "Unexpected exception: " . get_class($e) . " - " . $e->getMessage() . "\n";
        }
    }
})->with('fuzzing_inputs_with_attributes');



it('prepares a valid gift', function (): void {
	$gift = $this->service->prepareGift('Bitzee', 3, 'Purple', 'Plastic');

	expect($gift)->toBeInstanceOf(Gift::class);
});

it('retrieves attribute on gift', function (): void {
	$gift = $this->service->prepareGift('Furby', 1, 'Multi', 'Cotton');
	$gift->addAttribute(RECOMMENDED_AGE, '3');

	expect($gift->recommendedAge())->toBe(3);
});

it('fails for a too heavy gift', function (): void {
	$prepareGift = fn () => $this->service->prepareGift('Dog-E', 6, 'White', 'Metal');

	expect($prepareGift)->toThrow(InvalidArgumentException::class, 'Gift is too heavy for Santa\'s sleigh');
});
