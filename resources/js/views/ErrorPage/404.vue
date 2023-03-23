<template>

    <div class="h-72vh w-full flex flex-col justify-center items-center ">
        <h1 class="text-9xl font-extrabold text-white tracking-widest bg-hex-4141">404</h1>
        <div class="bg-hex-aa00 px-2 text-sm rounded rotate-12 absolute">
            Page Not Found
        </div>
        <button class="mt-5">
            <router-link to="/login">
                <a class="relative inline-block text-sm font-medium text-white group active:text-orange-500 focus:outline-none focus:ring" >
                    <span class="absolute inset-0 transition-transform translate-x-0.5 translate-y-0.5 bg-hex-aa00 group-hover:translate-y-0 group-hover:translate-x-0"></span>
                        <span class="relative block px-8 py-3 bg-hex-4141 border border-current">
                       Go Home
                    </span>
                </a>
            </router-link>
        </button>
    </div>

</template>
