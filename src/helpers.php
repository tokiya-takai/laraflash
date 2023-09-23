<?php

declare(strict_types=1);

use Tokiya\Laraflash\Flash;

if (!function_exists('flash')) {
    /**
     * フラッシュメッセージを表示する
     *
     * @param ?string $message
     *
     * @return Flash
     */
    function flash(?string $message = null): Flash {
        $flash = app()->make(Flash::class);
        assert($flash instanceof Flash);

        if ($message) {
            $flash->default($message);
        }

        return $flash;
    }
}
