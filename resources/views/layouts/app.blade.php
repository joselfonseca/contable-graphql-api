<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-screen antialiased">
    <div id="app" class="h-full bg-gray-100">
        <nav class="bg-indigo-800">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <img class="h-8 w-8" src="/svg/workflow-mark-on-dark.svg" alt="Workflow logo" />
                </div>
                <div class="hidden md:block">
                  <div class="ml-10 flex items-baseline">
                    @guest
                    @else
                        <router-link to="/incomes" active-class="bg-indigo-900" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-indigo-700 focus:outline-none focus:text-white focus:bg-indigo-700">Ingresos</router-link>
                        <router-link to="/accounts" active-class="bg-indigo-900" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-indigo-700 focus:outline-none focus:text-white focus:bg-indigo-700">Cuentas</router-link>
                        <router-link to="/categories" active-class="bg-indigo-900" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-indigo-700 focus:outline-none focus:text-white focus:bg-indigo-700">Categorías</router-link>
                    @endguest
                  </div>
                </div>
              </div>
              <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                  <div class="ml-3 relative">
                    <div class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true">
                        @include('partials.user')
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
        @yield('content')
      </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
