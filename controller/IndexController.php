<?php

    namespace Controller;

    use Core\Request;
    use Core\Validation;
    use Models\Task;

    class IndexController{

        public function index(Request $request){

            $data= array();
            $data['path'] = $request->getUrl();
            $data['isLogin'] = $request->isSessionLogin();

            //page navigation
            $limit = 3;
            $page = $request->get('page')?$request->get('page'):1;
            $data['page'] = $page;
            $count = Task::count();
            $data['count'] = $count%$limit == 0?$count/$limit:floor($count/$limit)+1;

            //sort
            $sort = $request->get('sort');
            $data['sortPath'] = $sort?"sort=$sort&":'';
            $data['sort'] = $sort;
            switch ($sort){
                case 'nameUp':
                    $data['tasks'] = Task::orderBy('name', 'asc')->skip($limit*($page-1))->take($limit)->get();
                    break;
                case 'nameDown':
                    $data['tasks'] = Task::orderBy('name', 'desc')->skip($limit*($page-1))->take($limit)->get();
                    break;
                case 'emailUp':
                    $data['tasks'] = Task::orderBy('email', 'asc')->skip($limit*($page-1))->take($limit)->get();
                    break;
                case 'emailDown':
                    $data['tasks'] = Task::orderBy('email', 'desc')->skip($limit*($page-1))->take($limit)->get();
                    break;
                case 'check':
                    $data['tasks'] = Task::orderBy('status', 'desc')->skip($limit*($page-1))->take($limit)->get();
                    break;
                case 'noCheck':
                    $data['tasks'] = Task::orderBy('status', 'asc')->skip($limit*($page-1))->take($limit)->get();
                    break;
                default:
                    $data['tasks'] = Task::orderBy('id', 'desc')->skip($limit*($page-1))->take($limit)->get();
                    break;
            }


            $data['title'] = "Главная старница";
            view('site\index', $data);
        }

        public function add(Request $request){
            $data= array();
            $data['isLogin'] = $request->isSessionLogin();

            if($request->isPost()){
                $name = $request->get('name');
                $email = $request->get('email');
                $text = $request->get('text');

                $validation = new Validation();
                $validation->validate('name', $name, array('required'));
                $validation->validate('email', $email, array('required', 'email'));
                $validation->validate('text', $text, array('required'));
                $errors = $validation->getErrors();

                if($errors){
                    $data['errors'] = $errors;
                    $data['old'] = array(
                        'name'  => $name,
                        'email' => $email,
                        'text'  => $text
                    );
                }
                else{
                    $task = new Task();
                    $task->name = $name;
                    $task->email = $email;
                    $task->text = $text;
                    $task->save();

                    $data['ok'] = 1;
                }
            }

            $data['title'] = "Добавить задание";
            view('site\add', $data);
        }

        public function edit(Request $request, $id){

            $data = array();
            $isLogin = $request->isSessionLogin();
            $data['isLogin'] = $isLogin;

            if($isLogin){
               $task = Task::find($id);
               if(isset($task->id)){
                   if($request->isPost()){
                       $text = $request->get('text');
                       if($task->edit){
                           $edit = $task->edit;
                       }
                       else{
                           $edit = $task->text == $text?0:1;
                       }
                       $check = $request->get('check')?1:0;

                       $validation = new Validation();
                       $validation->validate('text', $text, array('required'));
                       $errors = $validation->getErrors();
                       if($errors){
                           $data['errors'] = $errors;
                       }
                       else{
                           $task->text = $text;
                           $task->edit = $edit;
                           $task->status = $check;
                           $task->save();
                           $data['saved'] = true;
                       }

                   }
                   $data['task'] = $task;
               }
            }

            $data['title'] = "Редактирование записи";
            view('site\edit', $data);
        }
    }