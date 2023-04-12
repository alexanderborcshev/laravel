<?php

namespace App\Http\Middleware;

use App\Models\Bill;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Offer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProviderRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResource|JsonResponse
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);
        $user = Auth::user();
        if ($user && $user->inGroupsByCode([UserGroupCodeEnum::provider->name])) {
            $manager = $user->managers()->first();
            $provider_id = $manager->provider_id;
            $offer = Offer::where('provider_id', $provider_id)
                ->where('status', OfferStatusEnum::wait_public->name)
                ->first();
            $bill = Bill::where('provider_id', $provider_id)
                ->where('accept_date')
                ->first();
            $content = json_decode($response->content(), true);
            if ($offer) {
                $content = $this->array_merge($content, ['offer_redirect' => $offer->id]);
            }
            if ($bill) {
                $content = $this->array_merge($content, ['bill_redirect' => $bill->id]);
            }
            if (!$manager->rule) {
                $content = $this->array_merge($content, ['rule_redirect' => true]);
            }
            if (!$manager->first) {
                $content = $this->array_merge($content, ['first_redirect' => true]);
            }
            if ($offer || $bill || !$manager->first || !$manager->rule) {
                $response->setContent(json_encode($content));
            }
            return $response;
        }

        return $response;
    }

    public function array_merge(array $array1, array $array2): array
    {
        if (isset($array1['data']) && is_array($array1['data'])) {
            $array1['data'] = array_merge($array1['data'], $array2);
        } else {
            $array1 = array_merge($array1, $array2);
        }
        return $array1;
    }
}
