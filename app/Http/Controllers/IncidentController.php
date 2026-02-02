<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\PromptCheck;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncidentController extends Controller
{
	public function index()
	{
		return Inertia::render('Incidents/Index', [
			'incidents' => Incident::query()->latest()->paginate(20),
		]);
	}

	public function show(Incident $incident)
	{
		return Inertia::render('Incidents/Show', [
			'incident' => $incident,
		]);
	}

	public function storeFromCheck(Request $request, PromptCheck $promptCheck)
	{
		$data = $request->validate([
			'title' => ['required', 'string', 'max:255'],
		]);

		$incident = Incident::create([
			'title' => $data['title'],
			'category' => $this->categoryFromReasons($promptCheck->reasons ?? []),
			'severity' => $promptCheck->result === 'block' ? 'high' : 'medium',
			'status' => 'open',
			'prompt_snapshot' => $promptCheck->prompt,
			'prompt_check_id' => $promptCheck->id,
		]);

		return redirect()->route('incidents.show', $incident);
	}

	public function update(Request $request, Incident $incident)
	{
		$data = $request->validate([
			'status' => ['required', 'in:open,investigating,resolved,closed'],
			'notes' => ['nullable', 'string'],
		]);

		$incident->update($data);

		return redirect()->back();
	}

	private function categoryFromReasons(array $reasons): string
	{
		if (in_array('secret_like', $reasons, true)) return 'secrets';
		if (in_array('jailbreak_like', $reasons, true)) return 'jailbreak';
		if (in_array('pii_email', $reasons, true) || in_array('pii_phone_like', $reasons, true)) return 'pii';
		return 'policy';
	}
}
