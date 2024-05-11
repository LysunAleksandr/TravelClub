<?php

namespace App\Service;

use App\Entity\Travel;
use App\Repository\DiscountChildrenRepository;
use App\Repository\DiscountEarlyBookingRepository;

class TravelService
{
    const AGE_OF_MAJORITY = 18;

    public function __construct(
        private readonly DiscountChildrenRepository     $discountChildrenRepository,
        private readonly DiscountEarlyBookingRepository $discountEarlyBookingRepository,
    )
    {
    }

    public function calculate(Travel $travel): Travel
    {
        $today = new \DateTime();
        $age =  ($today->diff($travel->getDateBirth()))->y;

        $discountChildren = $age < self::AGE_OF_MAJORITY ? $this->discountChildrenRepository->getDiscountChildrenByClientAge($age) : null;
        if ($discountChildren) {
            $discount = $discountChildren->getDiscount()/100 * $travel->getBasicCost();
            if (null != $discountChildren->getMaxDiscount()) {
                $discount = $discount > $discountChildren->getMaxDiscount() ? $discountChildren->getMaxDiscount() : $discount;
            }
            $travel->setFullCost($travel->getBasicCost() - $discount);
        } else {
            $travel->setFullCost($travel->getBasicCost());
        }

        $date = getdate($travel->getDatePayment()?->getTimestamp());
        $monthPayment = $date['mon'];
        $yearPayment = $date['year'];

        $date = getdate($travel->getDateStart()?->getTimestamp());
        $dayTravel = $date['mday'];
        $monthTravel = $date['mon'];
        $yearTravel = $date['year'];

        $nextYear = $yearTravel-$yearPayment === 1;

        $discountEarlyBooking = $this->discountEarlyBookingRepository->getDiscountByDates(
            $nextYear,
            $dayTravel,
            $monthTravel,
            $monthPayment
        );

        if ($discountEarlyBooking) {
            $discount = $discountEarlyBooking->getDiscount()/100 * $travel->getFullCost();
            if (null != $discountEarlyBooking->getMaxDiscount()) {
                $discount = $discount > $discountEarlyBooking->getMaxDiscount() ? $discountEarlyBooking->getMaxDiscount() : $discount;
            }
            $travel->setFullCost($travel->getFullCost() - $discount);
        }

        return $travel;
    }

}
