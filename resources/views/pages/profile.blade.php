@extends('layouts.app')

@section('content')
<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Profile
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-12 xxl:col-span-9">

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-gray-200">
                    <h2 class="font-medium text-base mr-auto">
                        Display Information
                    </h2>
                    <div class="dropdown relative">
                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-700"></i> </a>
                        <div class="dropdown-box mt-5 absolute w-56 top-0 right-0 z-20">
                            <div class="dropdown-box__content box">
                                <div class="p-4 border-b border-gray-200 font-medium">Export Options</div>
                                <div class="p-2">
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="activity" class="w-4 h-4 text-gray-700 mr-2"></i> English </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="box" class="w-4 h-4 text-gray-700 mr-2"></i> Indonesia
                                        <div class="text-xs text-white px-1 rounded-full bg-theme-6 ml-auto">10</div>
                                    </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="layout" class="w-4 h-4 text-gray-700 mr-2"></i> English </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="sidebar" class="w-4 h-4 text-gray-700 mr-2"></i> Indonesia </a>
                                </div>
                                <div class="px-3 py-3 border-t border-gray-200 font-medium flex">
                                    <button type="button" class="button button--sm bg-theme-10 text-white">Settings</button>
                                    <button type="button" class="button button--sm bg-gray-200 text-gray-600 ml-auto">View Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-12 gap-5">
                        <div class="col-span-12 xl:col-span-4">
                            <div class="border border-gray-200 rounded-md p-5">
                                <div class="w-40 h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                    <img id="previewImage" class="rounded-md" alt="Avatar Profile" src="dist/images/profile-8.jpg">
                                    <div id="removePhoto" title="Remove this profile photo?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2"> <i data-feather="x" class="w-4 h-4"></i> </div>
                                </div>
                                <div class="w-40 mx-auto cursor-pointer relative mt-5">
                                    <button id="changePhotoButton" type="button" class="button w-full bg-theme-10 text-white">Change Photo</button>
                                    <input type="file" id="fileInput" class="w-full h-full top-0 left-0 absolute opacity-0">
                                </div>
                            </div>
                        </div>
                        <form method="post" action="{{ route('profile.update') }}" class="col-span-12 xl:col-span-8">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="mt-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                            {{ __('Your email address is unverified.') }}

                                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Display Information -->

            <!-- BEGIN: Change Password -->
            <div class="intro-y box lg:mt-8">
                <div class="flex items-center p-5 border-b border-gray-200">
                    <h2 class="font-medium text-base mr-auto">
                        Change Password
                    </h2>
                </div>
                <div class="p-5">
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </form>
                </div>
            </div>
            <!-- END: Change Password -->

        </div>
    </div>
</div>
<!-- END: Content -->
@endsection

@push('scripts')
<script>
    const fileInput = document.getElementById('fileInput');
    const previewImage = document.getElementById('previewImage');
    const removePhotoButton = document.getElementById('removePhoto');
    const changePhotoButton = document.getElementById('changePhotoButton');

    const defaultImageSrc = 'dist/images/profile-8.jpg';

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];

        if (file) {
            const objectURL = URL.createObjectURL(file);
            previewImage.src = objectURL;
            removePhotoButton.style.display = 'block';
        }
    });

    removePhotoButton.addEventListener('click', function () {
        fileInput.value = '';
        previewImage.src = defaultImageSrc;
        removePhotoButton.style.display = 'none';
    });

    changePhotoButton.addEventListener('click', function () {
        fileInput.click();
    });
</script>
@endpush
