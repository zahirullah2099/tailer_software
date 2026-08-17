<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Login</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="min-h-screen">

    <div class="min-h-screen relative flex items-center justify-center overflow-hidden">

        {{-- Background Image --}}
        <div class="absolute inset-0">

            <img src="{{ asset('images/login-tailor.jpg') }}" alt="Tailor working" class="w-full h-full object-cover">

            {{-- Dark overlay --}}
            <div class="absolute inset-0 bg-black/60"></div>

        </div>


        {{-- Main Content --}}
        <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-10">

            <div class="grid lg:grid-cols-2 gap-12 items-center">


                {{-- Left Side --}}
                <div class="hidden lg:block text-white">

                    <div class="flex items-center gap-3 mb-8">

                        <div
                            class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">

                            <i class="fa-solid fa-scissors text-2xl"></i>

                        </div>

                        <div>
                            <h1 class="text-2xl font-bold">
                                Tailor Management
                            </h1>

                            <p class="text-white/60 text-sm">
                                Smart management for your tailoring business
                            </p>
                        </div>

                    </div>


                    <h2 class="text-5xl font-bold leading-tight mb-6">
                        Manage your tailoring
                        <span class="text-blue-400">business</span>
                        with ease.
                    </h2>


                    <p class="text-white/70 text-lg max-w-lg leading-relaxed">
                        Manage customers, measurements, orders and payments
                        from one simple and powerful system.
                    </p>


                    {{-- Features --}}
                    <div class="mt-10 space-y-4">

                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">

                                <i class="fa-solid fa-users text-blue-400"></i>

                            </div>

                            <span class="text-white/80">
                                Manage your customers
                            </span>

                        </div>


                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">

                                <i class="fa-solid fa-ruler-combined text-blue-400"></i>

                            </div>

                            <span class="text-white/80">
                                Store customer measurements
                            </span>

                        </div>


                        <div class="flex items-center gap-4">

                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">

                                <i class="fa-solid fa-shirt text-blue-400"></i>

                            </div>

                            <span class="text-white/80">
                                Manage orders and payments
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Login Card --}}
                <div class="w-full max-w-md mx-auto">

                    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 sm:p-10">


                        {{-- Mobile Logo --}}
                        <div class="lg:hidden text-center mb-8">

                            <div
                                class="w-16 h-16 mx-auto rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg">

                                <i class="fa-solid fa-scissors text-2xl"></i>

                            </div>

                            <h1 class="text-2xl font-bold text-gray-900 mt-4">
                                Tailor Management
                            </h1>

                        </div>


                        {{-- Login Header --}}
                        <div class="mb-8">

                            <h2 class="text-3xl font-bold text-gray-900">
                                Welcome back
                            </h2>

                            <p class="text-gray-500 mt-2">
                                Login to your account to continue.
                            </p>

                        </div>


                        {{-- Login Form --}}
                        <form action="{{ route('login.store') }}" method="POST">

                            @csrf


                            {{-- Phone --}}
                            <div class="mb-5">

                                <label class="block text-sm font-semibold text-gray-700 mb-2">

                                    Phone Number

                                </label>


                                <div class="relative">

                                    <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    </i>


                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        placeholder="03XXXXXXXXX"
                                        class="w-full rounded-xl border border-blue-500 bg-gray-50 pl-11 pr-4 py-3.5 text-sm text-gray-900 outline-none transition focus:bg-white focus:border-blue-800 focus:ring-4 focus:ring-blue-500/10 @error('phone') border-red-500 @enderror">

                                </div>


                                @error('phone')
                                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                        {{ $message }}

                                    </p>
                                @enderror

                            </div>


                            {{-- Password --}}
                            <div class="mb-6">

                                <label class="block text-sm font-semibold text-gray-700 mb-2">

                                    Password

                                </label>


                                <div class="relative">

                                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    </i>


                                    <input type="password" name="password" placeholder="********"
                                        class="w-full rounded-xl border border-blue-500 bg-gray-50 pl-11 pr-4 py-3.5 text-sm text-gray-900 outline-none transition focus:bg-white focus:border-blue-800 focus:ring-4 focus:ring-blue-500/10 @error('password') border-red-500 @enderror">

                                </div>


                                @error('password')
                                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                        {{ $message }}

                                    </p>
                                @enderror

                            </div>


                            {{-- Login Button --}}
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white py-3.5 rounded-xl font-semibold transition duration-200 shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">

                                <i class="fa-solid fa-right-to-bracket"></i>

                                Login

                            </button>

                        </form>


                        {{-- Footer --}}
                        <div class="mt-8 pt-6 border-t border-gray-100 text-center">

                            <p class="text-xs text-gray-400">
                                © {{ date('Y') }} Tailor Management System
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
