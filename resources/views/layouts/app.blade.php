<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This view has the Page header for website.

-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('jquery-ui.min.css')}}">
    <link href="{{ asset('css/myStyles.css') }}" rel="stylesheet">

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }} " defer></script>
    <script src="{{asset('jquery-3.5.1.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('jquery-ui.min.js')}}" type="text/javascript" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>

@stack('head')

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex" href="{{ url('/') }}">
                    <div><img src="/svg/santiGramLogo.svg" alt="" style="height: 20px; border-right: 1px solid #333" class="pr-3"></div>
                    <div class="pl-3">SantiGram</div>
                </a>

                <input type="text" id="profileSearch">

                <a href="#" id="selectedProfile" class="darken">
                    <img src="/storage/images/Search-button.png" style="max-width: 30px;">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="/profile/{{ Auth::user()->id }}/conversations">
                                        {{ __('Mailbox') }}
                                    </a>

                                    <a class="dropdown-item" href="/profile/{{ Auth::user()->id }}">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="/profile/{{ Auth::user()->id }}/followers">
                                        {{ __('Followers') }}
                                    </a>

                                    <a class="dropdown-item" href="/profile/{{ Auth::user()->id }}/following">
                                        {{ __('Following') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>

                    <notification-button :profile-id="{{ is_null( Auth::user() ) ? '-1' : Auth::user()->profile->id }}">
                    </notification-button>

                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app_ProfileSearch.js') }} " type="text/javascript"></script>

</body>
</html>
