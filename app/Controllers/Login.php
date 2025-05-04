<?php

namespace App\Controllers;
use App\Models\LoginModel;

class Login extends BaseController
{

    public function index(){
        return view("login");
    }

    public function authUser(){
    {
        $loginModel = new LoginModel();
        $user = $loginModel->db->query(
            "CALL carteira.sp_validar_login(?, ?)", 
            [$this->request->getPost('email'), $this->request->getPost('senha')]
        );
        
        $result = $user->getResultArray(); 

        if($result){
            return redirect()->to('listausuarios');
        }
        else{
            return redirect()->back()->with('error', 'Credenciais inválidas');
        }

    }

}
}
