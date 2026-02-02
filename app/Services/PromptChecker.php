<?php

namespace App\Services;

class PromptChecker
{
	public function check(string $prompt): array
	{
		$reasons = [];
		$meta = [];

		// PII-ish signals
		$emailMatches = [];
		if (preg_match_all('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $prompt, $emailMatches)) {
			$reasons[] = 'pii_email';
			$meta['emails'] = array_values(array_unique($emailMatches[0]));
		}

		$phoneMatches = [];
		if (preg_match_all('/\+?\d[\d\s().-]{8,}\d/', $prompt, $phoneMatches)) {
			$reasons[] = 'pii_phone_like';
			$meta['phone_like'] = array_slice(array_values(array_unique($phoneMatches[0])), 0, 5);
		}

		// Secret-ish patterns (very rough)
		if (preg_match('/(sk-[A-Za-z0-9]{20,}|AKIA[0-9A-Z]{16}|ghp_[A-Za-z0-9]{30,})/', $prompt)) {
			$reasons[] = 'secret_like';
		}

		// Jailbreak-ish wording
		if (preg_match('/(ignore (all|any) (previous|prior) instructions|system prompt|jailbreak|do anything now)/i', $prompt)) {
			$reasons[] = 'jailbreak_like';
		}

		// Score/result
		$score = 0;
		foreach ($reasons as $r) {
			$score += match ($r) {
				'secret_like' => 60,
				'jailbreak_like' => 40,
				'pii_email', 'pii_phone_like' => 30,
				default => 10,
			};
		}
		$score = min(100, $score);

		$result = 'pass';
		if ($score >= 70) $result = 'block';
		elseif ($score >= 30) $result = 'warn';

		return [
			'result' => $result,
			'score' => $score,
			'reasons' => array_values(array_unique($reasons)),
			'meta' => $meta,
		];
	}
}
