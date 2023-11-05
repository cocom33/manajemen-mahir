@extends('layouts.app')

@section('content')
<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Update Profile
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-12 xxl:col-span-9">
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
                        <form action="{{ route('profile.update') }}" method="POST" class="col-span-12 xl:col-span-8">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name">Display Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"  class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" disabled>
                            </div>
                            <div class="mt-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="input w-full border mt-2" placeholder="Input text">
                            </div>
                            <button type="submit" class="button w-20 bg-theme-10 text-white mt-10">Save</button>
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
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div>
                            <label>Old Password</label>
                            <input type="password" name="current_password" class="input w-full border mt-2" placeholder="*******" autocomplete="current-password">
                            @error('current_password')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="input w-full border mt-2" placeholder="*******" autocomplete="new-password">
                        </div>
                        <div class="mt-3">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="input w-full border mt-2" placeholder="*******" autocomplete="new-password">
                        </div>
                        <button type="submit" class="button bg-theme-1 text-white mt-4">Change Password</button>
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
