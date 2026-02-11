<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import type { AppPageProps } from '@/types'
import { computed } from 'vue'
import { home, logout, login } from '@/routes'
import { index as incidentsIndex } from '@/routes/incidents'
import { create as promptCheckCreate } from '@/routes/prompt-check'

const page = usePage<AppPageProps>()
const isAuthenticated = computed(() => Boolean(page.props.auth?.user))

</script>


<template>
	<div class="relative min-h-screen overflow-hidden bg-slate-950 text-slate-100">
		<div class="pointer-events-none absolute inset-0">
			<div class="absolute -top-24 left-12 h-72 w-72 rounded-full bg-cyan-400/20 blur-3xl"></div>
			<div class="absolute right-8 top-1/3 h-80 w-80 rounded-full bg-emerald-400/20 blur-3xl"></div>
			<div class="absolute -bottom-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-sky-500/15 blur-3xl"></div>
		</div>

		<div class="relative flex min-h-screen flex-col">
		<!-- Header -->
		<header class="border-b border-white/10 bg-slate-950/70 text-white backdrop-blur">
			<div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
				<div class="font-semibold text-lg">
					<Link :href="home().url">
						Sentinel
					</Link>
				</div>

				<nav v-if="isAuthenticated" class="flex items-center gap-4 text-sm">
					<Link :href="promptCheckCreate().url" class="hover:underline">
						Prompt Check
					</Link>
					<Link :href="incidentsIndex().url" class="hover:underline">
						Incidents
					</Link>
					<Link
						:href="logout().url"
						method="post"
						as="button"
						class="cursor-pointer rounded border border-white/30 px-3 py-1 hover:bg-white/10"
					>
						Logout
					</Link>
				</nav>

				<nav v-else class="flex items-center gap-4 text-sm">
					<Link
						:href="login().url"
						class="cursor-pointer rounded border border-white/30 px-3 py-1 hover:bg-white/10"
					>
						Login
					</Link>
				</nav>
			</div>
		</header>

		<!-- Main content -->
		<main class="flex-1">
			<slot />
		</main>

		<!-- Footer -->
		<footer class="border-t border-white/10 bg-slate-950/70">
			<div class="max-w-6xl mx-auto px-6 py-4 text-sm text-slate-300">
				Sentinel · Prompt safety & incident logging
			</div>
		</footer>
		</div>
	</div>
</template>
