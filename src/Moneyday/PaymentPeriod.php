<?php

namespace Moneyday;


class PaymentPeriod {

    private $startDate;
    private $endDate;
    private $interval;
    private $nextMonth;

    public function __construct() {
        $this->startDate = new \DateTime('midnight');
        $this->endDate = new \DateTime('1st january next year');
        $this->interval = new \DateInterval('P1M');
        $this->nextMonth = new \DateTime('first day of next month');
    }

    public function getPaidPeriod(): array {
        $dates = [$this->startDate];
        $period = new \DatePeriod($this->nextMonth, $this->interval, $this->endDate);
        foreach ($period as $date) {
            array_push($dates, $date);
        }

        return $dates;
    }
}