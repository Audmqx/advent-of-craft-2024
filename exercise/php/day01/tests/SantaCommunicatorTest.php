<?php

declare(strict_types = 1);

use Communication\{Name, SantaCommunicator, Location, Reindeer, HolidayCoordination};
use Tests\doubles\TestLogger;

const NORTH_POLE = 'North Pole';
const DASHER = 'Dasher';
const NUMBER_OF_DAYS_TO_REST = 2;
const DAYS_FOR_COMING_BACK = 5;
const OVERDUE_DAYS = 25;

beforeEach(function (): void {
	$this->logger = new TestLogger;
	$this->reindeer =  new Reindeer(name: new Name(DASHER), location: new Location(NORTH_POLE));
});

it('composes a message', function (): void {
	$holidayCoordination = new HolidayCoordination(daysToRest: NUMBER_OF_DAYS_TO_REST, daysForComingBack: DAYS_FOR_COMING_BACK);
	$communicator = new SantaCommunicator(reindeer: $this->reindeer, holidayCoordination: $holidayCoordination);

	$message = $communicator->composeMessage($this->logger);
	$daysBeforeReturn = $holidayCoordination->daysBeforeReturn();

	expect($holidayCoordination->isOverdue())->toBeFalse();
	expect($message)->toBe("Dear Dasher, please return from North Pole in $daysBeforeReturn day(s) to be ready and rest before Christmas.");
});

it('detects overdue reindeer', function (): void {
	$holidayCoordination = new HolidayCoordination(daysToRest: OVERDUE_DAYS);
	$communicator = new SantaCommunicator(reindeer: $this->reindeer, holidayCoordination: $holidayCoordination);

	$message = $communicator->composeMessage($this->logger);

	expect($holidayCoordination->isOverdue())->toBeTrue();
	expect($message)->tobe('Overdue');
	expect($this->logger->loggedMessage())->toBe('Overdue for Dasher located North Pole.');
});




