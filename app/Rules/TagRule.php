<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TagRule implements Rule
{
    public function passes($attribute, $value)
    {
        // 先頭と末尾の#を削除
        $value = trim($value, '#');

        $tags = explode('#', $value);

        foreach ($tags as $tag) {
            $tag = trim($tag);  // タグの前後の空白を削除

            if (empty($tag)) {
                continue;
            }

            if (mb_strlen($tag, 'UTF-8') > 10) {
                return false;
            }
        }

        return true;
    }



    public function message()
    {
        return '各タグは10文字以内で入力してください。';
    }
}
