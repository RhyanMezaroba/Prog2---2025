<?php
// Compatibility wrapper expected by some controllers (AuthController, HomeController, etc.)
// Delegates to the existing userModel implementation.

require_once __DIR__ . '/userModel.php';

class User
{
    protected $m;

    public function __construct()
    {
        $this->m = new userModel();
    }

    public function create(array $data)
    {
        return $this->m->create($data);
    }

    public function findByEmail(string $email)
    {
        return $this->m->findByEmail($email);
    }

    public function findById($id)
    {
        // userModel->find espera id
        return $this->m->find($id);
    }
}
