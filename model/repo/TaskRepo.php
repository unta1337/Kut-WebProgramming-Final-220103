<!-- 할 일 리포지토리 클래스 -->

<?php
    class TaskRepo {
        private $connection;
        private $tableName;

        public function __construct($connection) {
            $this->connection = $connection;
            $this->tableName = 'task';
        }

        # 사용자 아이디로 할 일 불러오기.
        public function getTasksByAuthor($author) {
            $query = "SELECT task.id AS task_id, task, user.id AS author, user.id_uniq AS author_id_uniq, is_done FROM task JOIN user ON task.author_id_uniq = user.id_uniq WHERE user.id = '$author'";
            $result = mysqli_query($this->connection, $query);

            $tasks = [];
            while ($row = mysqli_fetch_array($result)) {
                array_push($tasks, $row);
            }

            return $tasks;
        }

        # 할 일 추가.
        public function addTask($task, $author_id_uniq) {
            $query = "INSERT INTO $this->tableName (task, author_id_uniq) VALUES ('$task', '$author_id_uniq')";
            mysqli_query($this->connection, $query);
        }

        # 할 일 삭제.
        public function deleteTask($id) {
            $query = "DELETE FROM $this->tableName WHERE id = $id";
            mysqli_query($this->connection, $query);
        }
    }
?>