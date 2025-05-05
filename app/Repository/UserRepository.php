<?php

namespace App\Repository;
use App\Interfaces\UserInterface;
use App\Models\UserModel;
use CodeIgniter\HTTP\Request;
use App\Services\AuthService;

class UserRepository  implements UserInterface
{

    private AuthService $senhaEmcriptada;

    public function __construct()
    {
        $this->senhaEmcriptada = new AuthService();
    }


    public function select(){
        $userModel = new UserModel();
        $data['users'] = $userModel->orderBy('id','desc')->findAll();
        return view('user_view', $data);
    }

    public function save(Request $request){
        
        $userModel = new UserModel();
        $senha = $this->senhaEmcriptada->encryptPassword($request->getPost('senha'));
        $userModel->protect(protect: false);
        $data = [ 
            'nome'=> $request->getPost('nome'),
            'email'=> $request->getPost('email'),
            'senha'=> $senha,
        ];
        $res = $userModel->insert($data);
        return $res;
    }

    public function update(Request $request){
        $userModel = new UserModel();
        $userModel->protect(protect: false);

        $data = [ 
            'id'=> $request->getPost('id'),
      
        ];
        $data['nome'] = $request->getPost('nome');
        $data['email'] = $request->getPost('email');
        $data['senha'] = $request->getPost('senha');

        $res = $userModel->update($data['id'], $data);
        return $res;
    }


    public function delete(Request $request){
        $userModel = new UserModel();
        $data = [ 
            'id'=> $request->getPost('id'), 
        ];
        $res = $userModel->delete($data['id']);
        return $res;    
    
    
    }
}
