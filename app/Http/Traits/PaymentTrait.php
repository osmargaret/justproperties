<?php

namespace App\Http\Traits;

use App\Models\Coupon;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

trait PaymentTrait
{
    use FlutterwaveTrait;
    use PaystackTrait;

    /**
     * Verifies and applies a coupon to a pending payment.
     * @return array{status: bool, message: string}
     */
    public function applyCoupon(Payment $payment, string $code): array
    {
        if ($payment->status !== 'pending') {
            return ['status' => false, 'message' => 'Cannot apply coupon to a non-pending payment.'];
        }

        if ($payment->coupon_id) {
            return ['status' => false, 'message' => 'A coupon has already been applied to this payment.'];
        }

        $coupon = Coupon::query()
            ->where('code', $code)
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('start_at')->orWhere('start_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return ['status' => false, 'message' => 'Invalid or expired coupon code.'];
        }

        if ($coupon->quantity <= 0) {
            return ['status' => false, 'message' => 'This coupon has reached its global usage limit.'];
        }

        if ($coupon->limit_per_user > 0) {
            $userUsageCount = Payment::query()
                ->where('user_id', $payment->user_id)
                ->where('coupon_id', $coupon->id)
                ->where('status', '!=', 'failed')
                ->count();
                
            if ($userUsageCount >= $coupon->limit_per_user) {
                return ['status' => false, 'message' => 'You have reached your usage limit for this coupon.'];
            }
        }

        if (!empty($coupon->eligible_items)) {
            $paymentableClass = strtolower(class_basename($payment->paymentable_type));
            $isEligible = in_array($paymentableClass, array_map('strtolower', $coupon->eligible_items), true);
            
            if (!$isEligible) {
                return ['status' => false, 'message' => 'This coupon is not valid for this type of purchase.'];
            }
        }

        // Apply discount. Ensure total doesn't go below zero.
        DB::transaction(function () use ($payment, $coupon) {
            $payment->coupon_id = $coupon->id;
            $payment->coupon_value = $coupon->discount;
            
            // Recalculate total: amount + vat_value - coupon_value
            $newTotal = $payment->amount + $payment->vat_value - $payment->coupon_value;
            $payment->total = max(0, $newTotal);
            $payment->save();

            // Deduct from coupon quantity
            $coupon->decrement('quantity');
        });

        return ['status' => true, 'message' => 'Coupon applied successfully!'];
    }

    /**
     * @return array{redirect_url: string, reference?: string}|false
     */
    public function initializePayment(Payment $payment): array|false
    {
        $gateway = $payment->method ?: $payment->currency?->payment_gateway;

        return match ($gateway) {
            'paystack' => ($url = $this->initiatePaystack($payment))
                ? ['redirect_url' => $url]
                : false,
            'flutterwave' => ($url = $this->initiateFlutterWave($payment))
                ? ['redirect_url' => $url, 'reference' => $payment->reference]
                : false,
            default => false,
        };
    }

    /**
     * @return array{status: bool, trx_status: string, amount: float, method: string}|null
     */
    protected function verifyPayment(Payment $payment): ?array
    {
        
        $gateway= $payment->gateway ?: $payment->currency?->payment_gateway;
        return match ($gateway) {
            'paystack' => $this->verifyPaystack($payment),
            'flutterwave' => $this->verifyFlutterwave($payment ),
            default => null,
        };
    }

    /**
     * @return array{status: bool, trx_status: string, amount: float, method: string}|null
     */
    protected function verifyPaystack(Payment $payment): ?array
    {
        $details = $this->verifyPaystackPayment($payment->reference);
        if (! $details || ! ($details->status ?? false)) {
            return null;
        }

        $data = $details->data ?? null;
        
        return [
            'status' => (bool) ($details->status ?? false),
            'trx_status' => (string) ($data['status'] ?? 'failed'),
            'amount' => ((float) ($data['amount'] ?? 0)) / 100,
            'method' => (string) ($data['channel'] ?? 'paystack'),
        ];
    }

    /**
     * @return array{status: bool, trx_status: string, amount: float, method: string}|null
     */
    protected function verifyFlutterwave(Payment $payment): ?array
    {
        $details = $this->verifyFlutterWavePayment($payment->reference);

        if (! $details) {
            return null;
        }

        $data = $details->data ?? null;
        $successful = ($details->status ?? '') === 'success' && ($data->status ?? '') === 'successful';

        if ($successful && isset($data->id)) {
            $payment->request_id = (string) $data->id;
            $payment->save();
        }

        return [
            'status' => $successful,
            'trx_status' => $successful ? 'success' : 'failed',
            'amount' => (float) ($data->amount ?? 0),
            'method' => (string) ($data->payment_type ?? 'flutterwave'),
        ];
    }
}
