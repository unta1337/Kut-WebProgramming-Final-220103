<!-- Repository Class -->

<?php
    class TaskRepo {
        private $connection;
        private $tableName;

        public function __construct($connection) {
            $this->connection = $connection;
            $this->tableName = 'task';
        }

        public function getTasks() {
            $query = "SELECT * FROM $this->tableName";
            $result = mysqli_query($this->connection, $query);

            $tasks = [];
            while ($row = mysqli_fetch_array($result)) {
                array_push($tasks, $row);
            }

            return $tasks;
        }

        public function getTasksByAuthorIdUniq($author_id_uniq) {
            $query = "SELECT task.id AS task_id, task, user.id AS author_id, user.id_uniq AS author_id_uniq, is_done FROM task JOIN user ON task.author_id_uniq = user.id_uniq WHERE id_uniq = $author_id_uniq";
            $result = mysqli_query($this->connection, $query);

            $tasks = [];
            while ($row = mysqli_fetch_array($result)) {
                array_push($tasks, $row);
            }

            return $tasks;
        }

        public function addTask($task, $author_id_uniq) {
            $query = "insert into $this->tableName (task, author_id_uniq) values ('$task', $author_id_uniq)";
            mysqli_query($this->connection, $query);
        }

        public function deleteTask($id) {
            $query = "delete from $this->tableName where id = $id";
            mysqli_query($this->connection, $query);
        }
    }
?>