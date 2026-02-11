<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';

const page = usePage();
const name = page.props.name;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="relative grid min-h-svh flex-col items-center justify-center overflow-hidden bg-slate-950 px-8 text-slate-100 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0"
    >
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -top-24 left-12 h-72 w-72 rounded-full bg-cyan-400/20 blur-3xl"></div>
            <div class="absolute right-8 top-1/3 h-80 w-80 rounded-full bg-emerald-400/20 blur-3xl"></div>
            <div class="absolute -bottom-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-sky-500/15 blur-3xl"></div>
        </div>

        <div
            class="relative hidden h-full flex-col border-r border-white/10 bg-slate-900/70 p-10 text-white backdrop-blur lg:flex"
        >
            <Link
                :href="home()"
                class="relative z-20 flex items-center text-lg font-medium"
            >
                <AppLogoIcon class="mr-2 size-8 fill-current text-white" />
                {{ name }}
            </Link>
        </div>
        <div class="relative z-10 lg:p-8">
            <div
                class="mx-auto flex w-full flex-col justify-center space-y-6 rounded-2xl border border-white/20 bg-slate-900/70 p-6 backdrop-blur sm:w-[350px]"
            >
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">
                        {{ title }}
                    </h1>
                    <p class="text-sm text-slate-300" v-if="description">
                        {{ description }}
                    </p>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
