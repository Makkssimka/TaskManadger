<?php

    namespace Controller;

    use Core\Request;
    use Core\Validation;
    use Models\User;

    class LoginController{

        public function index(Request $request){

            if($request->isSessionLogin()){
                header('Location: /');
            }

            $data= array();

            if($request->isPost()){
                $login = $request->get('login');
                $password = $request->get('password');

                $validation = new Validation();
                $validation->validate('login', $login, array('required'));
                $validation->validate('password', $password, array('required'));
                $errors = $validation->getErrors();

                if($errors){
                    $data['errors'] = $errors;
                    $data['old'] = array(
                        'login' => $login
                    );
                }
                else{
                    $user = User::where('login', $login)->where('password', md5($password))->first();
                    if(isset($user->id)){
                        $request->setSessionLogin($user->id);
                        header('Location: /');
                    }
                    else{
                        $data['errors'] = array(
                            'login' => 'Логин и пароль не совпадают'
                        );
                        $data['old'] = array(
                            'login' => $login
                        );
                    }
                }
            }

            $data['title'] = "Вход для администратора";
            view('site\login', $data);
        }

        public function logout(Request $request){
            $request->removeSessionLogin();
            header('Location: /');
        }
    }