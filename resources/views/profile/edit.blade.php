<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="p-6 bg-white shadow-sm sm:rounded-lg flex items-center gap-6">
                    <img src="{{ asset('storage/suci.jpg') }}"
                     alt="Foto Kandidat"
                     class="h-24 w-24 rounded-full object-cover ring-2 ring-gray-300">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Suci Indah Sari
                    </h2>
                    <p class="text-gray-600 text-lg">
                        IT Specialist
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Email: {{ Auth::user()->email }}
                    </p>
                </div>
            </section>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
