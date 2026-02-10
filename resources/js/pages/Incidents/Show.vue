<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
	incident: {
		id: number
		title: string
		category: string
		severity: string
		status: string
		prompt_snapshot: string
		notes: string | null
	}
}>()

const form = useForm({
	status: props.incident.status,
	notes: props.incident.notes ?? '',
})
</script>

<template>
	<div class="max-w-6xl mx-auto p-6 space-y-6">
		<h1 class="text-2xl font-semibold">
			{{ props.incident.title }}
		</h1>

		<div class="text-sm text-gray-600">
			{{ props.incident.category }} ·
			{{ props.incident.severity }} ·
			{{ props.incident.status }}
		</div>

		<div class="border rounded p-4">
			<div class="text-sm font-medium mb-2">Prompt snapshot</div>
			<pre class="text-sm whitespace-pre-wrap">{{ props.incident.prompt_snapshot }}</pre>
		</div>

		<form
			@submit.prevent="form.patch(`/incidents/${props.incident.id}`)"
			class="space-y-4"
		>
			<div>
				<label class="block text-sm font-medium mb-1">Status</label>
				<select v-model="form.status" class="w-full border rounded p-2">
					<option value="open">Open</option>
					<option value="investigating">Investigating</option>
					<option value="resolved">Resolved</option>
					<option value="closed">Closed</option>
				</select>
			</div>

			<div>
				<label class="block text-sm font-medium mb-1">Notes</label>
				<textarea
					v-model="form.notes"
					rows="4"
					class="w-full border rounded p-2"
				/>
			</div>

			<button class="bg-black text-white px-4 py-2 rounded">
				Update Incident
			</button>
			<div class="rounded bg-white text-black px-4 py-2 disabled:opacity-50 inline-block ml-4 border-1 border-solid border-black">
				<a href="/incidents">Back to Incidents</a>
			</div>
		</form>
	</div>
</template>

<script lang="ts">
	export default {
		layout: AppLayout,
	}
</script>