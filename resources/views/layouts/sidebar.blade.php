<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" {{-- <img alt="Logo" src="{{ asset('assets/media/logos/default-dark.svg') }}" --}}
                class="h-55px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" {{-- <img alt="Logo" src="{{ asset('assets/media/logos/default-small.svg') }}" --}}
                class="h-10px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('dashboard') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="#000000" width="800px" height="800px" viewBox="0 0 24 24" id="dashboard"
                                        data-name="Flat Color" xmlns="http://www.w3.org/2000/svg"
                                        class="icon flat-color">
                                        <path id="secondary"
                                            d="M22,4V7a2,2,0,0,1-2,2H15a2,2,0,0,1-2-2V4a2,2,0,0,1,2-2h5A2,2,0,0,1,22,4ZM9,15H4a2,2,0,0,0-2,2v3a2,2,0,0,0,2,2H9a2,2,0,0,0,2-2V17A2,2,0,0,0,9,15Z"
                                            style="fill: #D6001B;"></path>
                                        <path id="primary"
                                            d="M11,4v7a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V4A2,2,0,0,1,4,2H9A2,2,0,0,1,11,4Zm9,7H15a2,2,0,0,0-2,2v7a2,2,0,0,0,2,2h5a2,2,0,0,0,2-2V13A2,2,0,0,0,20,11Z"
                                            style="fill: rgb(0, 0, 0);"></path>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('user.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="currentColor" width="800px" height="800px" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">User</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('subscriptions.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="42.928px"
                                        height="42.928px" viewBox="0 0 42.928 42.928"
                                        style="enable-background:new 0 0 42.928 42.928;" xml:space="preserve">
                                        <g>
                                            <path fill="currentColor" d="M42.177,20.54l-3.771-2.041V7.927c0-0.53-0.291-1.021-0.758-1.272l-10.69-5.79c-0.433-0.233-0.947-0.233-1.38,0
  L14.887,6.654c-0.465,0.254-0.758,0.742-0.758,1.272v1.718l-1.301-0.705c-0.432-0.233-0.949-0.233-1.379,0l-10.691,5.79
  C0.291,14.983,0,15.47,0,16.001v13.188c0,0.53,0.291,1.021,0.758,1.272l10.693,5.79c0.215,0.116,0.451,0.176,0.688,0.176
  c0.236,0,0.474-0.06,0.688-0.176l5.826-3.156v1.903c0,0.531,0.291,1.021,0.761,1.273l10.689,5.789
  c0.215,0.115,0.451,0.176,0.689,0.176c0.236,0,0.473-0.061,0.689-0.176l10.688-5.789c0.465-0.254,0.758-0.742,0.758-1.273V21.813
  C42.936,21.281,42.642,20.792,42.177,20.54z M29.833,14.899l-2.115,1.146v-1.462l1.929-1.047V14.2
  C29.646,14.454,29.718,14.69,29.833,14.899z M30.796,17.668l7.649,4.145l-2.68,1.45l-7.191-4.391L30.796,17.668z M35.513,16.93
  l-3.319-1.797c0.215-0.253,0.351-0.576,0.351-0.934v-2.231l2.971-1.61L35.513,16.93L35.513,16.93z M26.27,3.783l7.651,4.144
  l-2.679,1.451l-7.196-4.392L26.27,3.783z M21.1,6.582l7.2,4.392l-2.028,1.1l-7.653-4.146L21.1,6.582z M12.139,11.858l1.99,1.08
  l5.66,3.063l-2.678,1.45l-2.982-1.818l-4.215-2.57L12.139,11.858z M12.141,20.147l-7.654-4.146l2.484-1.345l7.158,4.367
  l0.039,0.023l-0.039,0.021L12.141,20.147z M13.588,32.552v-9.896l0.963-0.521l0.967-0.521v0.665c0,0.18,0.037,0.349,0.096,0.506
  c0.207,0.55,0.732,0.939,1.353,0.939c0.108,0,0.215-0.015,0.317-0.035c0.646-0.146,1.129-0.723,1.129-1.41v-2.234l2.972-1.61v1.043
  l-1.967,1.064c-0.468,0.252-0.759,0.742-0.759,1.273v7.991L13.588,32.552z M30.798,25.956l-7.653-4.144l2.483-1.347l7.196,4.392
  L30.798,25.956z M40.038,34.14l-7.796,4.225v-9.896l1.931-1.046v0.665c0,0.8,0.647,1.447,1.446,1.447
  c0.8,0,1.447-0.647,1.447-1.447v-2.231l2.972-1.609V34.14L40.038,34.14z" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Subscriptions</span>
                        </span>
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
