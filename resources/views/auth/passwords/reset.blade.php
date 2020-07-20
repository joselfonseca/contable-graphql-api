@extends('layouts.app')

@section('content')
<x-auth-form>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-form-field name="email" label="E-Mail Address" type="email" />
        <x-form-field name="password" label="Password" type="password" />
        <x-form-field name="password_confirmation" label="Confirm Password" type="password" />
        <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    {{ __('Reset Password') }}
                </button>
            </span>
        </div>
    </form>
</x-auth-form>
@endsection
