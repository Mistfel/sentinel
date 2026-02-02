<?php

namespace App\Http\Controllers;

use App\Models\PromptCheck;
use App\Services\PromptChecker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromptCheckController extends Controller
{
	public function create()
	{
		return Inertia::render('PromptCheck/Create');
	}

	public function store(Request $request, PromptChecker $checker)
	{
		$data = $request->validate([
			'prompt' => ['required', 'string', 'min:3'],
			'purpose' => ['nullable', 'string', 'max:255'],
			'sensitivity' => ['required', 'in:public,internal,confidential,pii'],
		]);

		$result = $checker->check($data['prompt']);

		$check = PromptCheck::create([
			'prompt' => $data['prompt'],
			'purpose' => $data['purpose'] ?? null,
			'sensitivity' => $data['sensitivity'],
			'result' => $result['result'],
			'score' => $result['score'],
			'reasons' => $result['reasons'],
			'meta' => $result['meta'],
		]);

		return Inertia::render('PromptCheck/Create', [
			'check' => $check,
		]);
	}
}
