<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                @php($logo=\App\CentralLogics\helpers::get_business_settings('logo'))
                <a class="navbar-brand" href="{{route('organization.dashboard')}}" aria-label="Front">
                    <img class="w-100 side-logo"
                         src="{{Helpers::onErrorImage($logo, asset('storage/app/public/business') . '/' . $logo, asset('public/assets/admin/img/1920x400/img2.jpg'), 'business/')}}"
                         alt="Logo">
                </a>

                <div class="navbar-nav-wrap-content-left">
                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"></i>
                    </button>
                </div>
            </div>

            <div class="navbar-vertical-content search-bar-organization">
                <form class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input type="text" class="form-control form--control" placeholder="Search Menu..."
                               id="search-sidebar-menu">
                    </div>
                </form>

                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization')?'show':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="{{route('organization.dashboard')}}" title="{{translate('dashboard')}}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('dashboard')}}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{translate('account')}} {{translate('section')}}">{{translate('account')}} {{translate('management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization/transfer*')?'active':''}}">
                        <a class="nav-link " href="{{route('organization.transfer.index')}}"
                           title="{{translate('transfer')}}">
                            <i class="tio-users-switch nav-icon"></i>
                            <span class="text-truncate">{{translate('Transfer')}}</span>
                        </a>
                    </li>

                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization/transaction/index')?'active':''}}">
                        <a class="nav-link " href="{{route('organization.transaction.index', ['trx_type'=>'all'])}}"
                           title="{{translate('transaction')}}">
                            <i class="tio-money-vs nav-icon"></i>
                            <span class="text-truncate">{{translate('Transactions')}}</span>
                        </a>
                    </li>

                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization/expense/index')?'active':''}}">
                        <a class="nav-link " href="{{route('organization.expense.index')}}"
                           title="{{translate('Expense Transactions')}}">
                            <i class="tio-receipt-outlined nav-icon"></i>
                            <span class="text-truncate">{{translate('Expense Transactions')}}</span>
                        </a>
                    </li>
                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization/withdraw/requests')?'active':''}}">
                        <a class="nav-link " href="{{route('organization.withdraw.requests', ['request_status'=>'all'])}}"
                           title="{{translate('Agent Request Money')}}">
                            <i class="tio-pound-outlined nav-icon"></i>
                            <span class="text-truncate">{{translate('Withdraw_Requests')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{translate('user')}} {{translate('section')}}">{{translate('user')}} {{translate('management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization/customer*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-group-senior nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('customer')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('organization/customer*')?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/customer/add')?'active':''}}">
                                <a class="nav-link " href="{{route('organization.customer.add')}}"
                                   title="{{translate('add')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('register')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/customer/list')?'active':''}}">
                                <a class="nav-link " href="{{route('organization.customer.list')}}"
                                   title="{{translate('list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('list')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/customer/kyc-requests')?'active':''}}">
                                <a class="nav-link " href="{{route('organization.customer.kyc_requests')}}"
                                   title="{{translate('Verification Requests')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('Verification Requests')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="navbar-vertical-aside-has-menu {{Request::is('organization/transaction')?'show':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="{{route('organization.transaction', ['trx_type'=>'all'])}}"
                           title="{{translate('dashboard')}}">
                            <i class="tio-money-vs nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('transaction')}}
                            </span>
                        </a>
                    </li> -->
                    <!-- <li class="navbar-vertical-aside-has-menu {{Request::is('organization/withdraw*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-settings nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('Withdraw')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('organization/withdraw*')?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/withdraw/request')?'active':''}}">
                                <a class="nav-link " href="{{route('organization.withdraw.request')}}"
                                   title="{{translate('withdraw')}} {{translate('request')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span
                                        class="text-truncate">{{translate('withdraw')}} {{translate('request')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/withdraw/list')?'active':''}}">
                                <a class="nav-link "
                                   href="{{route('organization.withdraw.list', ['request_status'=>'all'])}}"
                                   title="{{translate('request')}} {{translate('list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('request')}} {{translate('list')}} </span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
<!-- 
                    <li class="navbar-vertical-aside-has-menu {{Request::is('organization/business-settings*')?'active':''}} mb-4">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-settings-outlined nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('developer')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('organization/business-settings*')?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/business-settings/shop-settings')?'active':''}}">
                                <a class="nav-link " href="{{route('organization.business-settings.shop-settings')}}"
                                   title="{{translate('shop')}} {{translate('settings')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('shop')}} {{translate('settings')}}</span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('organization/business-settings/integration-settings*')?'active':''}}">
                                <a class="nav-link " href="{{route('organization.business-settings.integration-settings')}}"
                                   title="{{translate('integration')}} {{translate('settings')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('integration')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->

                </ul>
            </div>
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>

@push('script_2')
    <script>
        $(window).on('load', function () {
            if ($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });

        var $rows = $('.navbar-vertical-content  .navbar-nav > li');
        $('#search-sidebar-menu').keyup(function () {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function () {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    </script>
@endpush
