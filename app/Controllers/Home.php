<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function userList(): string
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->orderBy('id','desc')->findAll();
        return view('user_view', $data);
    }

    public function insertUser()
    {
        $userModel = new UserModel();
        $userModel->protect(protect: false);
        $data = [ 
            'nome'=> $this->request->getPost('nome'),
            'email'=> $this->request->getPost('email'),
            'senha'=> $this->request->getPost('senha'),
        ];
        $res = $userModel->insert($data);
        if ($res) {
            return redirect()->to(uri: '/listausuarios'); 
        }
    }

    public function editUser(){
        $userModel = new UserModel();
        $userModel->protect(protect: false);

        $data = [ 
            'id'=> $this->request->getPost('id'),
      
        ];
        $data['nome'] = $this->request->getPost('nome');
        $data['email'] = $this->request->getPost('email');
        $data['senha'] = $this->request->getPost('senha');

        $userModel->update($data['id'], $data);
        return redirect()->to('/listausuarios'); 

    }

    public function deleteUser(){
        $userModel = new UserModel();
        $data = [ 
            'id'=> $this->request->getPost('id'), 
        ];
        $res = $userModel->delete($data['id']);
        if ($res) {
            return redirect()->to('/listausuarios'); 

        }
    }

}
