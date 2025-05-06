<?php

namespace App\Controllers;
use App\Infrastructure\Models\UserModel;
use App\Infrastructure\Repository\UserRepository;

class Home extends BaseController
{

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }



    public function index(): string
    {
        return view('login');
    }

    public function userList(): string
    {
        $userModel = new UserModel();
        $data[] = $this->userRepository->findAll();
        return view('user_view', $data);
    }

    public function insertUser()
    {
        $res = $this->userRepository->save($this->request);
        if ($res) {
            return redirect()->to(uri: '/listausuarios');
        }
    }

    public function editUser()
    {
        $res = $this->userRepository->update($this->request);
        if ($res) {
            return redirect()->to('/listausuarios');
        }
    }

    public function deleteUser()
    {
        $userModel = new UserModel();
        $data = [
            'id' => $this->request->getPost('id'),
        ];
        $res = $userModel->delete($data['id']);
        if ($res) {
            return redirect()->to('/listausuarios');

        }
    }

}
