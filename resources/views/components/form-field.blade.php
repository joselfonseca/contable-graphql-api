<div class="mb-6">
    <label for="{{ $name }}" class="block text-sm font-medium leading-5 text-gray-700">
        {{ __($label) }}
    </label>
    <div class="mt-1 rounded-md shadow-sm">
        <input id="{{ $name }}" type="{{ $type }}" @if($required) required @endif name="{{ $name }}" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
    </div>
    @error($name)
        <p class="text-red-500 text-xs italic mt-4">
            {{ $message }}
        </p>
    @enderror
</div>
