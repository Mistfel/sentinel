<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { fromCheck, index as incidentsIndex } from '@/routes/incidents';
import { store as promptCheckStore } from '@/routes/prompt-check';

const form = useForm({
    prompt: '',
    purpose: '',
    sensitivity: 'internal',
});

const props = defineProps<{
    check?: {
        id: number;
        result: 'pass' | 'warn' | 'block';
        score: number;
        reasons: string[] | null;
        meta: any;
        prompt: string;
    };
}>();

const hasResult = computed(() => !!props.check?.id);

const incidentTitle = ref('Prompt risk flagged');
</script>

<template>
    <div class="mx-auto max-w-6xl space-y-6 p-6">
        <h1 class="text-2xl font-semibold">Prompt Check</h1>

        <form
            @submit.prevent="form.post(promptCheckStore().url)"
            class="space-y-4"
        >
            <div>
                <label class="mb-1 block text-sm font-medium">Prompt</label>
                <textarea
                    v-model="form.prompt"
                    rows="8"
                    class="w-full rounded border p-2"
                />
                <div
                    v-if="form.errors.prompt"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.prompt }}
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium"
                        >Purpose</label
                    >
                    <input
                        v-model="form.purpose"
                        class="w-full rounded border p-2"
                        placeholder="e.g. Generate an email reply"
                    />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium"
                        >Sensitivity</label
                    >
                    <select
                        v-model="form.sensitivity"
                        class="w-full rounded border p-2"
                    >
                        <option value="public">Public</option>
                        <option value="internal">Internal</option>
                        <option value="confidential">Confidential</option>
                        <option value="pii">PII</option>
                    </select>
                </div>
            </div>

            <Button
                type="submit"
                variant="brand"
                size="lg"
                class="cursor-pointer"
                :disabled="form.processing"
            >
                Check Prompt
            </Button>
            <Button as-child variant="brand-outline" size="lg" class="ml-4">
                <Link :href="incidentsIndex().url"> View Incidents </Link>
            </Button>
        </form>

        <div v-if="hasResult" class="space-y-3 rounded border p-4">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium">
                    Result:
                    <span class="uppercase">{{ props.check!.result }}</span>
                </div>
                <div class="text-sm">Score: {{ props.check!.score }}/100</div>
            </div>

            <div v-if="props.check!.reasons?.length" class="space-y-2">
                <div class="text-sm font-medium">Reasons</div>
                <ul class="list-disc pl-5 text-sm">
                    <li v-for="r in props.check!.reasons" :key="r">{{ r }}</li>
                </ul>
            </div>

            <!-- Create incident when warn/block -->
            <div
                v-if="props.check!.result !== 'pass'"
                class="space-y-2 border-t pt-2"
            >
                <div class="text-sm font-medium">Create incident</div>
                <input
                    v-model="incidentTitle"
                    class="w-full rounded border p-2"
                />

                <form
                    @submit.prevent="
                        router.post(fromCheck(props.check!.id).url, {
                            title: incidentTitle,
                        })
                    "
                >
                    <Button variant="brand" size="lg" class="cursor-pointer">
                        Log Incident
                    </Button>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    layout: AppLayout,
};
</script>
