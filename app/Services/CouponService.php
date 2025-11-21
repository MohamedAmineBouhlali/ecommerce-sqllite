<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Str;

class CouponService
{
    public function validateCoupon(string $code, float $amount): ?Coupon
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return null;
        }

        if ($coupon->minimum_amount && $amount < $coupon->minimum_amount) {
            return null;
        }

        return $coupon;
    }

    public function calculateDiscount(Coupon $coupon, float $amount): float
    {
        return $coupon->calculateDiscount($amount);
    }

    public function createCoupon(array $data): Coupon
    {
        if (!isset($data['code'])) {
            $data['code'] = strtoupper(Str::random(8));
        } else {
            $data['code'] = strtoupper($data['code']);
        }

        return Coupon::create($data);
    }

    public function updateCoupon(Coupon $coupon, array $data): Coupon
    {
        if (isset($data['code'])) {
            $data['code'] = strtoupper($data['code']);
        }

        $coupon->update($data);
        return $coupon->fresh();
    }

    public function deleteCoupon(Coupon $coupon): bool
    {
        return $coupon->delete();
    }

    public function getAllCoupons(bool $activeOnly = false)
    {
        $query = Coupon::query();

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}

