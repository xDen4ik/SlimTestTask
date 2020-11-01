<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class AdminController extends Controller
{

    //Render view login 
    public function getUsers($request, $response)
    {
        $users = User::all();
        if (empty($this->auth->check())) {
            return $response->withRedirect($this->router->pathfor('home'));
        }
        return $this->view->render($response, 'admin/users.twig', ['users' => $users]);
    }

    //Render view edit 
    public function getUser($request, $response, $args = [])
    {

        $id_user = $args['id'];
        if (empty($id_user) || !is_numeric($id_user) || empty($this->auth->check())) {
            return $response->withRedirect($this->router->pathfor('home'));
        }

        $user = User::find($id_user);
        if (!$user) {
            return $response->withRedirect($this->router->pathfor('home'));
        }

        return $this->view->render($response, 'admin/edit.twig', ['user' => $user, 'id' => $args['id']]);
    }

    public function updateUser($request, $response)
    {
        $validation = $this->validator->validate(
            $request,
            [
                'first_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                'last_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                'email' => v::email(),
                'password' => v::noWhitespace()->notEmpty()->length(5, null),
            ]
        );
        

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor(
                'admin.edit',
                ['id' => $request->getParam('id')]
            ));
        }

        $user = User::find($request->getParam('id'));
        $user->first_name = $request->getParam('first_name');
        $user->last_name =  $request->getParam('last_name');
        $user->email = $request->getParam('email');
        if (!empty($request->getParam('password'))) {
            $user->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
        }
        $user->save();
        return $response->withRedirect($this->router->pathFor('admin.users'));
    }
}
