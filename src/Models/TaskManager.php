<?php
namespace Todo\Models;

use Todo\Models\Task;
/** Class UserManager **/
class TaskManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name, $listId)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM task WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $name,
            $listId
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"Todo\Models\Todo");

        return $stmt->fetch();
    }

    public function store() {
        $stmt = $this->bdd->prepare("INSERT INTO task(name, list_id) VALUES (?, ?)");
        $stmt->execute(array(
            $_POST["nameTask"],
            $_POST["list_id"]
        ));
    }

    // public function update($slug) {
    //     $stmt = $this->bdd->prepare("UPDATE List SET name = ? WHERE name = ? AND user_id = ?");
    //     $stmt->execute(array(
    //         $_POST['nameTodo'],
    //         $slug,
    //         $_SESSION["user"]["id"]
    //     ));
    // }

    // public function delete($slug) {

    //     $stmt = $this->bdd->prepare("DELETE FROM List WHERE id = ? AND user_id = ?");
    //     $stmt->execute(array(
    //         $_POST["idList"],
    //         $_SESSION["user"]["id"]
    //     ));
    // }

    public function getAll($listId)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM task WHERE list_id = ?');
        $stmt->execute(array($listId));

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Todo\Models\Todo");
    }

}