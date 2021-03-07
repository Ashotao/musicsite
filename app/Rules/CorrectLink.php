<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CorrectLink implements Rule
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
        $regex_pattern = "/(https:\/\/|http:\/\/|^)(w{3}\.youtube\.com|w{3}\.soundcloud\.com|youtube\.com|soundcloud\.com)(\/watch\?v=|\/.{1,25}\/).{1,255}/";
        $match = [];

        if (preg_match($regex_pattern, $value, $match)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Неправильная ссылка.(прим. правильной ссылки: https://www.youtube.com/watch?v=bHugxNlAbtM)';
    }
}
