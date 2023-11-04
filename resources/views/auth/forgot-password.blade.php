<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="./css/template.css" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="Mahir Techno Logo" class="w-25" src="./images/logo-2.png">
                    </a>
                    <div class="my-auto">
                        <img alt="Mahir Techno" class="-intro-x w-1/2 -mt-16" src="./images/Sentiment-analysis-rafiki.svg">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            Halaman
                            <br>
                            Forgot Password
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white">Masukan Email dan tunggu untuk mendapatkan pesan <br/> forgot password.</div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Forgot Password
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="intro-x mt-8">
                                <!-- Email Address -->
                                <x-input-label for="email" :value="__('Email')" />
                                <input class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Email" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <x-primary-button>
                                    {{ __('Email Password Reset Link') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="./js/template.js"></script>
    </body>
</html>
