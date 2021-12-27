<?php

namespace Moneyday;


class PaymentMonth {

    private $startDate;

    public function __construct(\DateTime $startDate) {
        $this->startDate = $startDate;
    }

    public function getMonth(): string {
        return $this->startDate->format('F');
    }

    public function getSalaryDay(): string {
        return $this->getSalaryPayday()->format('l jS');
    }

    public function getBonusDay(): string {
        $bonusDay = $this->getBonusPayday();
        return $bonusDay ? $bonusDay->format('l jS') : 'Already paid';
    }

    /**
     * bonus salary date
     */
    private function getSalaryPayday() {
        $lastDay = $this->startDate->modify('last day of this month');

        if ($this->IsWeekendDay($lastDay)) {
            $lastDay = $lastDay->modify('previous friday');
        }

        if ($this->startDate > $lastDay) {
            return null;
        }

        return $lastDay;
    }

    /**
     * bonus payout date
     */
    private function getBonusPayday() {
        $bonusDay = $this->startDate->modify('first day of this month')->modify('+14 days');

        if ($this->IsWeekendDay($bonusDay)) {
            $bonusDay = $bonusDay->modify('next wednesday');
        }

        $curDate = new \DateTime('midnight');
        if ($curDate > $bonusDay) {
            return null;
        }

        return $bonusDay;
    }

    /**
     * weekend check
     */
    private function IsWeekendDay(\DateTime $day): bool {
        return $day->format('N') >= 6;
    }
}