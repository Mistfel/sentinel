<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import {
    index as incidentsIndex,
    update as updateIncident,
} from '@/routes/incidents';

const props = defineProps<{
    incident: {
        id: number;
        title: string;
        category: string;
        severity: string;
        status: string;
        prompt_snapshot: string;
        notes: string | null;
    };
}>();

const form = useForm({
    status: props.incident.status,
    notes: props.incident.notes ?? '',
});
</script>

<template>
    <div class="mx-auto max-w-6xl space-y-6 p-6">
        <h1 class="text-2xl font-semibold">
            {{ props.incident.title }} -
            <span
                class="mr-1 inline-block h-4 w-4 rounded-full"
                :title="incident.severity"
                :class="{
                    'bg-emerald-600': incident.severity === 'low',
                    'bg-amber-600': incident.severity === 'medium',
                    'bg-orange-600': incident.severity === 'high',
                    'bg-red-600': incident.severity === 'critical',
                }"
            ></span>
        </h1>

        <div class="text-md text-white-600">
            {{ props.incident.category }} -
            {{ props.incident.status }}
        </div>

        <div class="rounded border bg-slate-800 p-4 opacity-50">
            <div class="mb-2 text-sm font-medium">Prompt snapshot</div>
            <pre class="text-sm whitespace-pre-wrap">{{
                props.incident.prompt_snapshot
            }}</pre>
        </div>

        <form
            @submit.prevent="form.patch(updateIncident(props.incident.id).url)"
            class="space-y-4"
        >
            <div>
                <label class="mb-1 block text-sm font-medium">Status</label>
                <select v-model="form.status" class="w-full rounded border p-2">
                    <option value="open">Open</option>
                    <option value="investigating">Investigating</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Notes</label>
                <textarea
                    v-model="form.notes"
                    rows="4"
                    class="w-full rounded border p-2"
                />
            </div>

            <Button variant="brand" size="lg"> Update Incident </Button>
            <Button as-child variant="brand-outline" size="lg" class="ml-4">
                <Link :href="incidentsIndex().url"> Back to Incidents </Link>
            </Button>
        </form>
    </div>
</template>

<script lang="ts">
export default {
    layout: AppLayout,
};
</script>
