<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { computed } from 'vue'

const props = defineProps<{
	incidents: {
		data: Array<{
			id: number
			title: string
			severity: string
			status: string
			category: string
			created_at: string
		}>
	}
}>()

const incidents = computed(() => props.incidents.data)
</script>

<template>
	<div class="max-w-4xl mx-auto p-6 space-y-6">
		<h1 class="text-2xl font-semibold">Incidents</h1>

		<div v-if="incidents.length === 0" class="text-gray-600">
			No incidents logged yet.
		</div>

		<div v-else class="space-y-3">
			<div
				v-for="incident in incidents"
				:key="incident.id"
				class="border rounded p-4 flex justify-between items-center"
			>
				<div>
					<div class="font-medium">{{ incident.title }}</div>
					<div class="text-sm text-gray-600">
						{{ incident.category }} · {{ incident.severity }} · {{ incident.status }}
					</div>
				</div>

				<a
					:href="`/incidents/${incident.id}`"
					class="text-sm underline"
				>
					View
				</a>
			</div>
		</div>

		<div class="pt-4">
			<a href="/" class="underline text-sm">
				← Back to prompt check
			</a>
		</div>
	</div>
</template>

<script lang="ts">
    export default {
        layout: AppLayout,
    }
</script>
