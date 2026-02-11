<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { fromCheck, index as incidentsIndex } from '@/routes/incidents'
import { store as promptCheckStore } from '@/routes/prompt-check'

const form = useForm({
	prompt: '',
	purpose: '',
	sensitivity: 'internal',
})

const props = defineProps<{
	check?: {
		id: number
		result: 'pass' | 'warn' | 'block'
		score: number
		reasons: string[] | null
		meta: any
		prompt: string
	}
}>()

const hasResult = computed(() => !!props.check?.id)

const incidentTitle = ref('Prompt risk flagged')
</script>

<template>
	<div class="max-w-6xl mx-auto p-6 space-y-6">
		<h1 class="text-2xl font-semibold">Prompt Check</h1>

		<form @submit.prevent="form.post(promptCheckStore().url)" class="space-y-4">
			<div>
				<label class="block text-sm font-medium mb-1">Prompt</label>
				<textarea v-model="form.prompt" rows="8" class="w-full rounded border p-2" />
				<div v-if="form.errors.prompt" class="text-sm text-red-600 mt-1">{{ form.errors.prompt }}</div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div>
					<label class="block text-sm font-medium mb-1">Purpose</label>
					<input v-model="form.purpose" class="w-full rounded border p-2" placeholder="e.g. Generate an email reply" />
				</div>

				<div>
					<label class="block text-sm font-medium mb-1">Sensitivity</label>
					<select v-model="form.sensitivity" class="w-full rounded border p-2">
						<option value="public">Public</option>
						<option value="internal">Internal</option>
						<option value="confidential">Confidential</option>
						<option value="pii">PII</option>
					</select>
				</div>
			</div>

			<button type="submit" class="inline-flex items-center rounded-xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300 cursor-pointer" :disabled="form.processing">
				Check Prompt
			</button>
			<Link
				:href="incidentsIndex().url"
				class="inline-flex items-center rounded-xl border border-white/30 bg-white/6 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/14 ml-4"
			>
				View Incidents
			</Link>
		</form>

		<div v-if="hasResult" class="rounded border p-4 space-y-3">
			<div class="flex items-center justify-between">
				<div class="text-lg font-medium">
					Result: <span class="uppercase">{{ props.check!.result }}</span>
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
			<div v-if="props.check!.result !== 'pass'" class="pt-2 border-t space-y-2">
				<div class="text-sm font-medium">Create incident</div>
				<input v-model="incidentTitle" class="w-full rounded border p-2" />

				<form @submit.prevent="router.post(fromCheck(props.check!.id).url, { title: incidentTitle })">
					<button class="inline-flex items-center rounded-xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300 cursor-pointer">
						Log Incident
					</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
	export default {
		layout: AppLayout,
	}
</script>
