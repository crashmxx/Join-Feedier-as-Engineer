<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Thanks for applying to Feedier!
            </h1>

            <div class="mt-6 space-y-1">
                <p class="text-gray-500 leading-relaxed">
                    One of the key stages of our recruitment process is the technical test. All developers on our team go through this stage in order to be able to join Feedier.
                </p>

                <p class="text-gray-500 leading-relaxed">
                    The purpose of this test is mainly to see your adaptability and your comfort on our technical stack.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    This site uses the same technical stack as Feedier: VueJS, InertiaJS, Laravel and TailwindCSS. More commonly called <span class="font-semibold text-gray-700">VILT Stack</span>.
                </p>
            </div>
        </div>
    </div>
</template>
