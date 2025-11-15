<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function store()
    {
        helper(['form', 'url']);

        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[5]',
            'confirm_password' => 'matches[password]',
            'image'            => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UserModel();

        // handle file upload
        $img = $this->request->getFile('image');
        $originalName = $img->getName();
        $img->move('uploads/users', $originalName);

        $userModel->save([
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'customer',
            'status'   => 1,
            'image'    => $originalName
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful! You can now log in.');
    }

    public function auth()
    {
        helper(['form', 'url']);
        $session    = session();
        $userModel  = new UserModel();
        $email      = $this->request->getVar('email');
        $password   = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            $session->setFlashdata('error', 'Email not found.');
            return redirect()->to('/login');
        }

        if (!password_verify($password, $user['password'])) {
            $session->setFlashdata('error', 'Invalid password.');
            return redirect()->to('/login');
        }
        // block inactive staff
        if ($user['status'] === '0') {
            $session->setFlashdata('error', 'Account is inactive. Contact admin.');
            return redirect()->to('/login');
        }

        $sessionData = [
            'user_id'   => $user['user_id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'isLoggedIn' => true
        ];
        $session->set($sessionData);

        // Redirect by role (case-insensitive)
        switch (strtolower($user['role'])) {
            case 'admin':
                return redirect()->to('/admin');
            case 'staff':
                return redirect()->to('/staff');
            default:
                return redirect()->to('/kathys_crochet_flowers');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
