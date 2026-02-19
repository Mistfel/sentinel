<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { index as incidentsIndex } from '@/routes/incidents';
import { create as promptCheckCreate } from '@/routes/prompt-check';
</script>

<template>
    <div
        class="mx-auto flex w-full max-w-6xl flex-col gap-14 px-6 py-14 sm:py-18 lg:py-24"
    >
        <section
            class="grid gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:items-center"
        >
            <div class="space-y-6">
                <p
                    class="inline-flex rounded-full border border-white/20 bg-white/8 px-4 py-1 text-xs font-semibold tracking-[0.2em] text-cyan-200 uppercase"
                >
                    Prompt Safety Platform
                </p>
                <h1
                    class="max-w-xl text-4xl font-semibold tracking-tight text-white sm:text-5xl"
                >
                    Catch risky prompts before they become incidents.
                </h1>
                <p
                    class="max-w-2xl text-base leading-relaxed text-slate-200 sm:text-lg"
                >
                    Sentinel checks prompts for policy, privacy, and abuse
                    risks, then gives teams a fast way to log and track
                    incidents when something needs review.
                </p>
                <div class="flex flex-wrap gap-3">
                    <Button as-child variant="brand" size="lg">
                        <Link :href="promptCheckCreate().url" prefetch>
                            Start a Prompt Check
                        </Link>
                    </Button>
                    <Button as-child variant="brand-outline" size="lg">
                        <Link :href="incidentsIndex().url" prefetch>
                            View Incident Queue
                        </Link>
                    </Button>
                </div>
            </div>

            <div class="grid gap-4">
                <div
                    class="rounded-2xl border border-cyan-300/30 bg-slate-900/70 p-5 backdrop-blur"
                >
                    <p class="text-xs tracking-[0.2em] text-cyan-200 uppercase">
                        Score Signal
                    </p>
                    <p class="mt-2 text-3xl font-semibold text-white">
                        0-100 Risk Scale
                    </p>
                    <p class="mt-3 text-sm text-slate-300">
                        Each prompt gets a clear score and pass, warn, or block
                        result to support quick triage.
                    </p>
                </div>
                <div
                    class="rounded-2xl border border-emerald-300/30 bg-slate-900/70 p-5 backdrop-blur"
                >
                    <p
                        class="text-xs tracking-[0.2em] text-emerald-200 uppercase"
                    >
                        Incident Ready
                    </p>
                    <p class="mt-2 text-3xl font-semibold text-white">
                        One-Click Escalation
                    </p>
                    <p class="mt-3 text-sm text-slate-300">
                        Flagged results can be converted into incidents
                        immediately so nothing gets lost.
                    </p>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-3">
            <div
                class="rounded-2xl border border-white/15 bg-slate-900/70 p-5 backdrop-blur"
            >
                <p class="text-xs tracking-[0.18em] text-slate-300 uppercase">
                    1. Submit
                </p>
                <p class="mt-2 text-lg font-semibold text-white">
                    Enter prompt context
                </p>
                <p class="mt-2 text-sm text-slate-300">
                    Add the prompt, purpose, and sensitivity level so analysis
                    can be contextual.
                </p>
            </div>
            <div
                class="rounded-2xl border border-white/15 bg-slate-900/70 p-5 backdrop-blur"
            >
                <p class="text-xs tracking-[0.18em] text-slate-300 uppercase">
                    2. Analyze
                </p>
                <p class="mt-2 text-lg font-semibold text-white">
                    Review score + reasons
                </p>
                <p class="mt-2 text-sm text-slate-300">
                    See why a prompt passed, warned, or blocked based on
                    detected risk patterns.
                </p>
            </div>
            <div
                class="rounded-2xl border border-white/15 bg-slate-900/70 p-5 backdrop-blur"
            >
                <p class="text-xs tracking-[0.18em] text-slate-300 uppercase">
                    3. Respond
                </p>
                <p class="mt-2 text-lg font-semibold text-white">
                    Track in incident queue
                </p>
                <p class="mt-2 text-sm text-slate-300">
                    Create an incident to investigate, assign ownership, and
                    close the loop.
                </p>
            </div>
        </section>

        <section
            class="rounded-3xl border border-white/15 bg-white/7 p-6 backdrop-blur sm:p-8"
        >
            <div
                class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between"
            >
                <div>
                    <h2 class="text-2xl font-semibold text-white">
                        What Sentinel protects against
                    </h2>
                    <p
                        class="mt-2 max-w-3xl text-sm leading-relaxed text-slate-200"
                    >
                        Monitor common risk categories like PII leakage, hidden
                        secrets, policy violations, and jailbreak attempts.
                        Teams can audit all checks and incidents in one place.
                    </p>
                </div>
                <Button
                    as-child
                    size="default"
                    class="w-fit bg-white text-slate-900 hover:bg-slate-100"
                >
                    <Link :href="promptCheckCreate().url" prefetch>
                        Run Your First Check
                    </Link>
                </Button>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
export default {
    layout: AppLayout,
};
</script>
