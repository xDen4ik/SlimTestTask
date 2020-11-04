<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\UserLogs;
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
        $user = User::find($request->getParam('id'));

        if ($user['email'] == $request->getParam('email')) {
            $validation = $this->validator->validate(
                $request,
                [
                    'first_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                    'last_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                ]
            );
        } else {
            $validation = $this->validator->validate(
                $request,
                [
                    'first_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                    'last_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                    'email' => v::email()->EmailEvalible(),
                ]
            );
        }



        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor(
                'admin.edit',
                ['id' => $request->getParam('id')]
            ));
        }


        $user->first_name = $request->getParam('first_name');
        $user->last_name =  $request->getParam('last_name');
        $user->email = $request->getParam('email');
        if (!empty($request->getParam('password'))) {
            $user->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
        }
        $user->save();
        return $response->withRedirect($this->router->pathFor('admin.users'));
    }

    public function getUsersLogs($request, $response)
    {
        $logs = UserLogs::leftJoin('sessions', 'user_logs.session_id', '=', 'sessions.session_id')
            ->leftJoin('users', 'users.id', '=', 'user_logs.user_id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'user_logs.created_at', 'sessions.device_type', 'sessions.browser', 'user_logs.log_id', 'sessions.user_ip', 'sessions.action ')
            ->orderByRaw('user_logs.log_id DESC')
            ->get();

        return $this->view->render($response, 'admin/logs.twig', ['logs' => $logs]);
    }
}
