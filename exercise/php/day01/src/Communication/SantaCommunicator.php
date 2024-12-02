<?php

declare(strict_types = 1);

namespace Communication;

class SantaCommunicator
	{
		
		public function __construct(private Reindeer $reindeer, private HolidayCoordination $holidayCoordination)
		{}

		public function composeMessage(ILogger $logger): string
		{
			if($this->holidayCoordination->isOverdue()){
				$logger->log("Overdue for {$this->reindeer->name()} located {$this->reindeer->location()}.");
				return 'Overdue';
			}

			return "Dear {$this->reindeer->name()}, please return from {$this->reindeer->location()} in {$this->holidayCoordination->daysBeforeReturn()} day(s) to be ready and rest before Christmas.";
		}
	}
