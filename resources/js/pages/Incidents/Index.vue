<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { show as incidentsShow } from '@/routes/incidents';
import { create as promptCheckCreate } from '@/routes/prompt-check';

const props = defineProps<{
    incidents: {
        data: Array<{
            id: number;
            title: string;
            severity: string;
            status: string;
            category: string;
            created_at: string;
        }>;
    };
}>();

const incidents = computed(() => props.incidents.data);
const searchText = ref('');
const categoryFilter = ref('all');
const severityFilter = ref('all');

const filteredIncidents = computed(() => {
    return incidents.value.filter((incident) => {
        const q = searchText.value.trim().toLowerCase();
        const matchesSearch =
            q === '' ||
            incident.title.toLowerCase().includes(q) ||
            incident.category.toLowerCase().includes(q);

        const matchesStatus =
            severityFilter.value === 'all' ||
            incident.status === severityFilter.value;

        const matchesCategory =
            categoryFilter.value === 'all' ||
            incident.category === categoryFilter.value;

        return matchesSearch && matchesStatus && matchesCategory;
    });
});
</script>

<template>
    <div class="mx-auto max-w-6xl space-y-6 p-6">
        <h1 class="text-2xl font-semibold">Incidents</h1>

        <Button as-child variant="brand" size="lg">
            <Link :href="promptCheckCreate().url">
                ← Back to prompt check
            </Link>
        </Button>

        <div class="float-right flex gap-3">
            <input
                v-model="searchText"
                type="text"
                placeholder="Search incidents..."
                class="rounded border px-3 py-2 text-sm"
            />
            <select
                v-model="categoryFilter"
                class="rounded border px-3 py-2 text-sm"
            >
                <option value="all">All Categories</option>
                <option value="pii">PII</option>
                <option value="secrets">Secrets</option>
                <option value="jailbreak">Jailbreak</option>
                <option value="policy">Policy</option>
                <option value="other">Other</option>
            </select>
            <select
                v-model="severityFilter"
                class="rounded border px-3 py-2 text-sm"
            >
                <option value="all">All Severities</option>
                <option value="open">Open</option>
                <option value="investigating">Investigating</option>
                <option value="resolved">Resolved</option>
                <option value="closed">Closed</option>
            </select>
        </div>

        <div v-if="filteredIncidents.length === 0" class="text-gray-600">
            No incidents logged yet.
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="incident in filteredIncidents"
                :key="incident.id"
                class="flex items-center justify-between rounded border p-4"
            >
                <div>
                    <div class="font-medium">{{ incident.title }}</div>
                    <div class="text-white-600 text-sm capitalize">
                        <span
                            class="relative top-1 mr-1 inline-block h-4 w-4 rounded-full"
                            :title="incident.severity"
                            :class="{
                                'bg-emerald-600': incident.severity === 'low',
                                'bg-amber-600': incident.severity === 'medium',
                                'bg-orange-600': incident.severity === 'high',
                                'bg-red-600': incident.severity === 'critical',
                            }"
                        ></span>
                        - {{ incident.category }} - {{ incident.status }}
                    </div>
                </div>

                <Link
                    :href="incidentsShow(incident.id).url"
                    class="text-sm underline"
                >
                    View
                </Link>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    layout: AppLayout,
};
</script>
