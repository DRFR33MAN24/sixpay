<?php

namespace App\Http\Controllers\Organization;

use App\CentralLogics\helpers;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessSettingsController extends Controller
{
    public function __construct(
        private Organization $organization,
    )
    {
    }

    /**
     * @return Application|Factory|View
     */
    public function shopIndex(): Factory|View|Application
    {
        $organization = $this->organization->where(['user_id' => auth()->user()->id])->first();
        return view('organization-views.business-settings.shop-index', compact('organization'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function shopUpdate(Request $request): RedirectResponse
    {
        $organization = $this->organization->where(['user_id' => auth()->user()->id])->first();

        if ($request->has('logo')) {
            $logo = Helpers::update('organization/', $organization->logo, 'png', $request->file('logo'));
        } else {
            $logo = $organization['logo'];
        }

        $organization->store_name = $request->store_name;
        $organization->callback = $request->callback;
        $organization->address = $request->address;
        $organization->bin = $request->bin;
        $organization->logo = $logo;
        $organization->update();

        Toastr::success(translate('Successfully updated.'));
        return back();
    }

    /**
     * @return Application|Factory|View
     */
    public function integrationIndex(): Factory|View|Application
    {
        $organization = $this->organization->where(['user_id' => auth()->user()->id])->first();
        return view('organization-views.business-settings.integration-index', compact('organization'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function integrationUpdate(Request $request): JsonResponse
    {
        $organization = $this->organization->where(['user_id' => auth()->user()->id])->first();
        $organization->public_key = Str::random(50);
        $organization->secret_key = Str::random(50);
        $organization->update();

        return response()->json([
            'organization' => $organization,
            'success' => translate('Successfully updated.')
        ]);
    }


}
