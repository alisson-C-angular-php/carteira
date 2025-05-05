<?php

namespace App\Controllers;
use App\Models\LoginModel;
use App\Services\AuthService;

class Login extends BaseController
{

    
    private AuthService $senhaEmcriptada;

    public function __construct()
    {
        $this->senhaEmcriptada = new AuthService();
    }

    public function index(){
        return view("login");
    }

    public function authUser(){
    {
        $loginModel = new LoginModel();
      
        $user = $loginModel->db->query(
            "CALL carteira.sp_validar_login(?)", 
            [$this->request->getPost('email')]
        );
        
        $result = $user->getResultArray(); 
        if (!empty($result) && password_verify($this->request->getPost('senha'), $result[0]['senha'])) {
            session()->set([
                'user' =>  $result[0]['nome'],
                'logged_in' => true
            ]);
            return redirect()->to('/listausuarios');
        }
    }

}
}
