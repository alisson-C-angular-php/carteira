<?php

namespace App\Controllers;
use App\Infrastructure\Models\LoginModel;
use App\Domain\Services\AuthService;

class Login extends BaseController
{


    private AuthService $senhaEmcriptada;

    public function __construct()
    {
        $this->senhaEmcriptada = new AuthService();
    }

    public function index()
    {
        return view("login");
    }

    public function cadUser()
    {
        return view("caduser");

    }

    public function authUser()
    {
        $loginModel = new LoginModel();

        $user = $loginModel->db->query(
            "CALL carteira.sp_validar_login(?)",
            [$this->request->getPost('email')]
        );

        $result = $user->getResultArray();

        if (empty($result)) {
            return redirect()->to('/')->with('error', 'O email informado não foi encontrado.');
        } elseif (!password_verify($this->request->getPost('senha'), $result[0]['senha'])) {
            return redirect()->to('/')->with('error', 'A senha informada está incorreta.');
        } else {
            session()->set([
                'user_id' => $result[0]['id'],
                'user_name' => $result[0]['nome'],
                'logged_in' => true
            ]);
            return redirect()->to('/listausuarios');
        }
    }

}



