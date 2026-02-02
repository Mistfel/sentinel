<script setup lang="ts">
</script>

<template>
	<div class="min-h-screen flex flex-col bg-gray-50">
		<!-- Header -->
		<header class="bg-black text-white">
			<div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
				<div class="font-semibold text-lg">
					Sentinel
				</div>

				<nav class="space-x-4 text-sm">
					<a href="/prompt-check" class="hover:underline">
						Prompt Check
					</a>
					<a href="/incidents" class="hover:underline">
						Incidents
					</a>
				</nav>
			</div>
		</header>

		<!-- Main content -->
		<main class="flex-1 text-black">
			<slot />
		</main>

		<!-- Footer -->
		<footer class="border-t bg-white">
			<div class="max-w-6xl mx-auto px-6 py-4 text-sm text-gray-600">
				Sentinel · Prompt safety & incident logging
			</div>
		</footer>
	</div>
</template>
