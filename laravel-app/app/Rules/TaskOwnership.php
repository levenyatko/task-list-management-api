<?php

namespace App\Rules;

use App\Repositories\TaskRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaskOwnership implements ValidationRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = true;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $user_id = auth()->user()->id;
        $owned = TaskRepository::isOwnedBy(intval($value), $user_id);
        if (! $owned) {
            $fail("The {$attribute} is invalid. You must be the task owner.");
        }
    }
}
