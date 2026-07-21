<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Property;
use App\Models\Subscription;
use App\Services\Promotions\ActivatesPromotionAfterPayment;
use Illuminate\Support\Facades\DB;

class CompletesPayment
{
    public function complete(Payment $payment, ?string $gatewayMethod = null, ?array $gatewayPayload = null): void
    {
        if ($payment->status === 'completed' || $payment->status === 'success') {
            return;
        }

        DB::transaction(function () use ($payment, $gatewayMethod, $gatewayPayload) {
            $payment->status = 'completed';
            $payment->paid_at = now();
            if ($gatewayMethod) {
                $payment->method = $gatewayMethod;
            }
            if ($gatewayPayload !== null) {
                $payment->gateway_payload = $gatewayPayload;
            }
            $payment->save();

            // if ($payment->paymentable_type === Property::class && $payment->paymentable_id) {
            //     $property = Property::whereKey($payment->paymentable_id)->first();
            //     $property->is_published = true;
            //     $property->save();
            // }

            if ($payment->paymentable_type === Subscription::class && $payment->paymentable_id) {
                $subscription = Subscription::query()
                    ->with('subscribedProperties')
                    ->find($payment->paymentable_id);

                if ($subscription) {
                    $subscription->status = 'active';
                    $subscription->save();

                    $propertyIds = $subscription->subscribedProperties
                        ->pluck('property_id')
                        ->filter()
                        ->all();
                    if (! empty($propertyIds)) {
                        $properties = Property::whereIn('id', $propertyIds)->get();
                        foreach($properties as $property){
                            $property->is_published = true;
                            $property->save();
                        }
                    }
                }
            }

            if ($payment->paymentable_type === Promotion::class && $payment->paymentable_id) {
                $promotion = Promotion::query()->find($payment->paymentable_id);
                if ($promotion) {
                    app(ActivatesPromotionAfterPayment::class)->activate($promotion);
                }
            }
        });
    }
}
