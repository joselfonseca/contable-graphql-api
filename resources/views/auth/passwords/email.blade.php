@extends('layouts.app')

@section('content')
<x-logo-on-forms action="Reset Password" />
<x-auth-form>
    @if(session('status'))
        <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <x-form-field name="email" label="E-Mail Address" type="email" />
        <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    {{ __('Send Password Reset Link') }}
                </button>
            </span>
        </div>
    </form>
</x-auth-form>
@endsection
