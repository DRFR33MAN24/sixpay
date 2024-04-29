<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\helpers;
use App\Http\Controllers\Controller;
use App\Models\EMoney;
use App\Models\Organization;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class OrganizationController extends Controller
{
    public function __construct(
        private Organization $organization,
        private User $user,
        private EMoney $e_money,
        private Transaction $transaction
    ){}

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Factory|View|Application
    {
        $ip = env('APP_MODE') == 'live' ? $request->ip() : '61.247.180.82';
        $currentUserInfo = Location::get($ip);
        return view('admin-views.organization.index', compact('currentUserInfo'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function list(Request $request): Factory|View|Application
    {
        $queryParam = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $organizations = $this->user->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $queryParam = ['search' => $request['search']];
        } else {
            $organizations = $this->user;
        }

        $organizations = $organizations->with('organization')->organizationUser()->latest()->paginate(Helpers::pagination_limit())->appends($queryParam);
        return view('admin-views.organization.list', compact('organizations', 'search'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'org_name' => 'required',

            'image' => 'required',
            'country_code' => 'required',
            'phone' => 'required|unique:users|min:8|max:20',
            'password' => 'required|min:8',


            'address' => 'required',

            'logo' => 'required',

        ],[
            'password.min' => translate('Password must contain 8 characters'),
            'country_code.required' => translate('Country code select is required')
        ]);

        $phone = $request->country_code . $request->phone;
        $organization = $this->user->where(['phone' => $phone])->first();
        if (isset($organization)){
            Toastr::warning(translate('This phone number is already taken'));
            return back();
        }

        try {
            DB::beginTransaction();

            if ($request->has('image')) {
                $imageName = Helpers::upload('organization/', 'png', $request->file('image'));
            } else {
                $imageName = 'def.png';
            }

            if ($request->has('logo')) {
                $logo = Helpers::upload('organization/', 'png', $request->file('logo'));
            } else {
                $logo = 'def.png';
            }



            $user = $this->user;
           

            $user->email = $request->email;
            $user->dial_country_code = $request->country_code;
            $user->phone = $phone;
            $user->password = bcrypt($request->password);
            $user->type = ORGANIZATION_TYPE;    //['Admin'=>0, 'Agent'=>1, 'Customer'=>2, 'Organization'=>3]
            $user->image = $imageName;

            $user->is_kyc_verified = 1;
            $user->save();

            $user->find($user->id);
            $user->unique_id = $user->id . mt_rand(1111, 99999);
            $user->save();

            $organization = $this->organization;
            $organization->user_id = $user->id;
            $organization->org_name= $request->org_name;

            $organization->address = $request->address;

            $organization->logo = $logo;

            $organization->organization_number = $request->phone;
            $organization->save();

            $emoney = $this->e_money;
            $emoney->user_id = $user->id;
            $emoney->save();

            DB::commit();

            Toastr::success(translate('Organization Added Successfully!'));
            return redirect()->route('admin.Organization.list');
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            Toastr::warning(translate('Organization Added Failed!'));
            return back();
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function status(Request $request): RedirectResponse
    {
        $user = $this->user->find($request->id);
        $user->is_active = !$user->is_active;
        $user->save();
        Toastr::success('organization status updated!');
        return back();
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id): Factory|View|Application
    {
        $user = $this->user->find($id);
        $organization = $this->organization->where(['user_id' => $user->id])->first();
        return view('admin-views.organization.edit', compact('user','organization' ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'org_name' => 'required',



            'address' => 'required',

        ],[

        ]);

        try {
            DB::beginTransaction();

            $user = $this->user->find($id);
            $organization = $this->organization->where(['user_id' => $user->id])->first();

            if ($request->has('image')) {
                $imageName = Helpers::update('organization/', $user->image, 'png', $request->file('image'));
            } else {
                $imageName = $user['image'];
            }

            if ($request->has('logo')) {
                $logo = Helpers::update('organization/', $organization->logo, 'png', $request->file('logo'));
            } else {
                $logo = $organization['logo'];
            }




            $user->email = $request->has('email') ? $request->email : $user->email;

            if ($request->has('password') && strlen($request->password) > 7) {
                $user->password = bcrypt($request->password);
            }

            $user->image = $imageName;

            $user->update();

            $organization->user_id = $user->id;
            $organization->org_name = $request->org_name;

            $organization->address = $request->address;
 
            $organization->logo = $logo;
            $organization->update();

            DB::commit();

            Toastr::success(translate('organization Updated Successfully!'));
            return redirect()->route('admin.organization.list');
        }catch (\Exception $exception){
            DB::rollBack();
            Toastr::warning(translate('organization Updated Failed!'));
            return back();
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function view($id): Factory|View|Application
    {
        $user = $this->user->with('emoney', 'organization')->find($id);
        return view('admin-views.view.details', compact('user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View
     */
    public function transaction(Request $request, $id): Factory|View|Application
    {
        $queryParam = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);

            $users = $this->user->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('id', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            })->get()->pluck('id')->toArray();

            $transactions = $this->transaction->where(function ($q) use ($key, $users) {
                foreach ($key as $value) {
                    $q->orWhereIn('from_user_id', $users)
                        ->orWhere('to_user_id', $users)
                        ->orWhere('transaction_type', 'like', "%{$value}%")
                        ->orWhere('transaction_id', 'like', "%{$value}%")
                        ->orWhere('balance', 'like', "%{$value}%");
                }
            });
            $queryParam = ['search' => $request['search']];
        } else {
            $transactions = $this->transaction;
        }

        $transactions = $transactions->where('user_id', $id)->latest()->paginate(Helpers::pagination_limit())->appends($queryParam);

        $user = $this->user->find($id);
        return view('admin-views.view.transaction', compact('user', 'transactions', 'search'));
    }

}
