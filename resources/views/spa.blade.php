@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="w-full flex flex-row">
            <div class="w-1/4 pr-4">
                <div class="overflow-hidden shadow-lg border-t-4 bg-white mb-4 rounded-b-lg border-blue-900 rounded-t w-full">
                    <div class="px-6 py-4 mb-2 mt-4 mb-8 text-blue-900">
                        <router-link to='/transactions' active-class="bg-blue-500 text-white" class="flex cursor-pointer p-2 mb-2">
                            <svg class="fill-current inline-block h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z"/>
                            </svg>
                            <div class="pl-2">Transacciones</div>
                        </router-link>
                        <router-link to='/accounts' active-class="bg-blue-500 text-white" class="flex cursor-pointer p-2 mb-2">
                            <svg class="fill-current inline-block h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z"/>
                            </svg>
                            <div class="pl-2">Cuentas</div>
                        </router-link>
                        <router-link to='/categories' active-class="bg-blue-500 text-white" class="flex cursor-pointer p-2 mb-2">
                            <svg class="fill-current inline-block h-6 w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z"/>
                            </svg>
                            <div class="pl-2">Categorías</div>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="w-3/4 p-4 shadow-lg border-t-4 bg-white mb-4 rounded-b-lg rounded-t border-blue-900 w-full mt-0">
                <router-view></router-view>
            </div>
        </div>
    </div>
@endsection
