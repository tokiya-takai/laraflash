<?php

declare(strict_types=1);

namespace Tokiya\Laraflash;

use Illuminate\Session\Store;

class Flash
{
    /** @var string */
    public const SUCCESS = 'success';

    /** @var string */
    public const WARNING = 'warning';

    /** @var string */
    public const ERROR = 'error';

    /** @var string */
    public const INFO = 'info';

    /** @var string */
    public const SESSION_KEY = 'flash_message';

    /** @var string */
    public const SESSION_FLASH_LEVEL_KEY = 'flash_level';

    /** @var array<string, string> */
    private array $level_keys = [
        'success' => self::SUCCESS,
        'warning' => self::WARNING,
        'error'   => self::ERROR,
        'info'    => self::INFO,
    ];

    /** @var array<string, string> */
    private array $default_messages = [
        'success' => '成功しました！',
        'warning' => '注意が必要です。',
        'error'   => 'エラーが発生しました。',
        'info'    => 'お知らせがあります。',
    ];

    /** @var string */
    private string $default_method = 'success';

    public function __construct(private Store $session)
    {
    }

    public function __call(string $name, array $arguments)
    {
        $message = $arguments[0] ?? null;

        $this->other($name, $message);
    }

    /**
     * Get the message.
     *
     * @return ?string
     */
    public function getMessage(): ?string
    {
        return $this->session->get(self::SESSION_KEY);
    }

    /**
     * Set default message on success.
     *
     * @param string $message
     *
     * @return self
     */
    public function setDefaultSuccessMessage(string $message): self
    {
        $this->default_messages[$this->getSuccessKey()] = $message;

        return $this;
    }

    /**
     * Set default message when there is a warning.
     *
     * @param string $message
     *
     * @return self
     */
    public function setDefaultWarningMessage(string $message): self
    {
        $this->default_messages[$this->getWarningKey()] = $message;

        return $this;
    }

    /**
     * Set default message on error.
     *
     * @param string $message
     *
     * @return self
     */
    public function setDefaultErrorMessage(string $message)
    {
        $this->default_messages[$this->getErrorKey()] = $message;

        return $this;
    }

    /**
     * Set default message when there is a notification.
     *
     * @param string $message
     *
     * @return self
     */
    public function setDefaultInfoMessage(string $message): self
    {
        $this->default_messages[$this->getInfoKey()] = $message;

        return $this;
    }

    /**
     * Get the default message corresponding to the level.
     *
     * @param string $message
     *
     * @return string
     */
    public function getDefaultMessage(string $level): string
    {
        return $this->default_messages[$level];
    }

    /**
     * Does the message exist?
     *
     * @return bool
     */
    public function hasMessage(): bool
    {
        return $this->getMessage() !== null;
    }

    /**
     * Get the level.
     *
     * @return string
     */
    public function getLevel(): string
    {
        return $this->session->get(self::SESSION_FLASH_LEVEL_KEY);
    }

    /**
     * Get the success key.
     *
     * @return string
     */
    public function getSuccessKey(): string
    {
        return $this->level_keys['success'];
    }

    /**
     * Get the warning key.
     *
     * @return string
     */
    public function getWarningKey(): string
    {
        return $this->level_keys['warning'];
    }

    /**
     * Get the error key.
     *
     * @return string
     */
    public function getErrorKey(): string
    {
        return $this->level_keys['error'];
    }

    /**
     * Get the information key.
     *
     * @return string
     */
    public function getInfoKey(): string
    {
        return $this->level_keys['info'];
    }

    /**
     * Customize the success key.
     *
     * @param string $key
     *
     * @return self
     */
    public function customizeSuccessKey(string $key = self::SUCCESS): self
    {
        $this->level_keys['success'] = $key;

        return $this;
    }

    /**
     * Customize the warning key.
     *
     * @param string $key
     *
     * @return self
     */
    public function customizeWarningKey(string $key = self::WARNING): self
    {
        $this->level_keys['warning'] = $key;

        return $this;
    }

    /**
     * Customize the error key.
     *
     * @param string $key
     *
     * @return self
     */
    public function customizeErrorKey(string $key = self::ERROR): self
    {
        $this->level_keys['error'] = $key;

        return $this;
    }

    /**
     * Customize the information key.
     *
     * @param string $key
     *
     * @return self
     */
    public function customizeInfoKey(string $key = self::INFO): self
    {
        $this->level_keys['info'] = $key;

        return $this;
    }

    /**
     * Show the default flash message.
     *
     * @param string $message
     *
     * @return self
     */
    public function default(string $message): self
    {
        $this->{$this->default_method}($message);

        return $this;
    }

    /**
     * Show the flash message on success.
     *
     * @param ?string $message
     *
     * @return self
     */
    public function success(?string $message = null): self
    {
        if (!$message) {
            $message = $this->getMessage();
        }
        if (!$message) {
            $message = $this->getDefaultMessage($this->getSuccessKey());
        }

        $this->show($message);

        $this->setLevel($this->getSuccessKey());

        return $this;
    }

    /**
     * Show the flash message when there is a warning.
     *
     * @param ?string $message
     *
     * @return self
     */
    public function warning(?string $message = null): self
    {
        if (!$message) {
            $message = $this->getMessage();
        }

        $this->show($message);

        $this->setLevel($this->getWarningKey());

        return $this;
    }

    /**
     * Show the flash message on error.
     *
     * @param ?string $message
     *
     * @return self
     */
    public function error(?string $message = null): self
    {
        if (!$message) {
            $message = $this->getMessage();
        }

        $this->show($message);

        $this->setLevel($this->getErrorKey());

        return $this;
    }

    /**
     * Show the flash message when there is a notification.
     *
     * @param ?string $message
     *
     * @return self
     */
    public function info(?string $message = null): self
    {
        if (!$message) {
            $message = $this->getMessage();
        }

        $this->show($message);

        $this->setLevel($this->getInfoKey());

        return $this;
    }

    /**
     * Show the flash message.
     *
     * @param string $message
     *
     * @return void
     */
    private function show(string $message): void
    {
        $this->session->flash(self::SESSION_KEY, $message);
    }

    /**
     * Set a flash message level.
     *
     * @param string $key
     *
     * @return void
     */
    private function setLevel(string $key): void
    {
        $this->session->put(self::SESSION_FLASH_LEVEL_KEY, $key);
    }

    /**
     * Show the flash message on a level that does not exist.
     *
     * @param string $level
     * @param ?string $message
     *
     * @return self
     */
    private function other(string $level, ?string $message = null): self
    {
        if (!$message) {
            $message = $this->getMessage();
        }

        $this->show($message);

        $this->setLevel($level);

        return $this;
    }
}
