<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { index as incidentsIndex, update as updateIncident } from '@/routes/incidents'

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
			{{ props.incident.title }} - <span
							class="h-4 w-4 inline-block rounded-full mr-1"
							:title="incident.severity"
							:class="{
								'bg-emerald-600': incident.severity === 'low',
								'bg-amber-600': incident.severity === 'medium',
								'bg-orange-600': incident.severity === 'high',
								'bg-red-600': incident.severity === 'critical'
							}"
						></span>
		</h1>

		<div class="text-md text-white-600">
			{{ props.incident.category }} -
			{{ props.incident.status }}
		</div>

		<div class="border rounded p-4 bg-slate-800 opacity-50">
			<div class="text-sm font-medium mb-2">Prompt snapshot</div>
			<pre class="text-sm whitespace-pre-wrap">{{ props.incident.prompt_snapshot }}</pre>
		</div>

		<form
			@submit.prevent="form.patch(updateIncident(props.incident.id).url)"
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

			<button class="inline-flex items-center rounded-xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
				Update Incident
			</button>
			<Link
				:href="incidentsIndex().url"
				class="inline-flex items-center rounded-xl border border-white/30 bg-white/6 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/14 ml-4"
			>
				Back to Incidents
			</Link>
		</form>
	</div>
</template>

<script lang="ts">
	export default {
		layout: AppLayout,
	}
</script>
