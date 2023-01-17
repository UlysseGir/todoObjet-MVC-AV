<?php

namespace Todo\Controllers;

use Todo\Models\TaskManager;
use Todo\Validator;

/** Class TodoController **/
class TaskController {
    private $manager;
    private $validator;

    public function __construct() {
        $this->manager = new TaskManager();
        $this->validator = new Validator();
    }

    public function index() {
        require VIEWS . 'Todo/homepage.php';
    }

    public function create() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Todo/create.php';
    }

    public function store() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        // $this->validator->validate([
        //     "name"=>["required", "min:2", "alphaNumDash"]
        // ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTask"], $_POST["list_id"]);

            if (empty($res)) {
                $this->manager->store();
                header("Location: /dashboard/" . $_POST["nameList"]);
            } else {
                $_SESSION["error"]['name'] = "Le nom de la Task est déjà utilisé !";
                header("Location: /dashboard/nouveau");
            }
        } else {
            header("Location: /dashboard/nouveau");
        }
    }

    // public function update($slug) {
    //     if (!isset($_SESSION["user"]["username"])) {
    //         header("Location: /login");
    //         die();
    //     }
    //     $this->validator->validate([
    //         "nameTodo"=>["required", "min:2", "alphaNumDash"]
    //     ]);
    //     $_SESSION['old'] = $_POST;

    //     if (!$this->validator->errors()) {
    //         $res = $this->manager->find($_POST["nameTodo"], $_SESSION["user"]["id"]);

    //         if (empty($res) || $res->getName() == $slug) {
    //             $search = $this->manager->update($slug);
    //             header("Location: /dashboard/" . $_POST['nameTodo']);
    //         } else {
    //             $_SESSION["error"]['nameTodo'] = "Le nom de la liste est déjà utilisé !";
    //             header("Location: /dashboard/" . $slug);
    //         }

    //     } else {
    //         header("Location: /dashboard/" . $slug);
    //     }
    // }

    // public function delete($slug)
    // {
    //     if (!isset($_SESSION["user"]["username"])) {
    //         header("Location: /login");
    //         die();
    //     }
    //     $this->manager->delete($slug);
    //     header("Location: /dashboard");
    // }

}
