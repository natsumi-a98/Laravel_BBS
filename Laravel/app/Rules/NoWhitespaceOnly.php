<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoWhitespaceOnly implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // 値が空でなく、半角・全角スペースのみでないことを確認
        // 全角スペースも無効とするため、正規表現を適切に設定する
        return !empty(trim($value)) && !preg_match('/^[\pZ\s]+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attributeが空欄またはスペースのみです。';
    }
}
