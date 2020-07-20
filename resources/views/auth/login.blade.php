@extends('layouts.app')

@section('content')
    <x-logo-on-forms action="Login" />
    <x-auth-form>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <x-form-field name="email" label="E-Mail Address" type="email" />
            <x-form-field name="password" label="Passsword" type="password" />
            <div class="mt-6 flex items-center justify-between">
              <div class="flex items-center">
                <input id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                <label for="remember" class="ml-2 block text-sm leading-5 text-gray-900">
                    {{ __('Remember Me') }}
                </label>
              </div>
              @if (Route::has('password.request'))
              <div class="text-sm leading-5">
                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    {{ __('Forgot Your Password?') }}
                </a>
              </div>
              @endif
            </div>

            <div class="mt-6">
              <span class="block w-full rounded-md shadow-sm">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    {{ __('Login') }}
                </button>
              </span>
            </div>
          </form>
    </x-auth-form>
@endsection
