<?php
namespace App\Core;

class BaseController
{
    protected $viewsPath;

    public function __construct(string $viewsPath = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // caminho padrão para views: app/Views/ (ajustado ao layout deste projeto)
        $this->viewsPath = $viewsPath ?? (__DIR__ . '/../Views/');
    }

    protected function setViewsPath(string $path)
    {
        $this->viewsPath = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    protected function render(string $viewFile, array $data = [])
    {
        extract($data, EXTR_SKIP);
        $file = $this->viewsPath . $viewFile . '.php';
        if (!file_exists($file)) {
            throw new \RuntimeException("View not found: {$file}");
        }
        require $file;
    }

    protected function redirect(string $url = null)
    {
        $url = $url ?? ($_SERVER['HTTP_REFERER'] ?? '/');
        header('Location: ' . $url);
        exit;
    }

    protected function setFlash(string $key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    protected function getFlash(string $key)
    {
        $v = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $v;
    }

    protected function setOld(array $data)
    {
        $_SESSION['old'] = $data;
    }

    protected function getOld(): array
    {
        $v = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        return $v;
    }

    protected function setErrors(array $errors)
    {
        $_SESSION['errors'] = $errors;
    }

    protected function getErrors(): array
    {
        $v = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        return $v;
    }

    protected function sanitizeInput(array $input): array
    {
        $clean = [];
        foreach ($input as $k => $v) {
            $clean[$k] = is_string($v) ? trim($v) : $v;
        }
        return $clean;
    }
}
?>