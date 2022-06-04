<!-- 할 일 리포지토리 클래스 -->

<?php
    class TaskRepo {
        private $connection;
        private $tableName;

        public function __construct($connection) {
            $this->connection = $connection;
            $this->tableName = 'task';
        }

        # 고유 번호로 할 일 불러오기.
        public function getTaskById($id) {
            $query = "SELECT * FROM $this->tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();

            $task = mysqli_fetch_array($result);

            return $task;
        }

        # 사용자 아이디로 할 일 불러오기.
        public function getTasksByAuthor($author) {
            $query = "SELECT task.id AS task_id, task, user.id AS author, user.id_uniq AS author_id_uniq, is_done FROM task JOIN user ON task.author_id_uniq = user.id_uniq WHERE user.id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('s', $author);
            $stmt->execute();

            $result = $stmt->get_result();

            $tasks = [];
            while ($row = mysqli_fetch_array($result)) {
                array_push($tasks, $row);
            }

            return $tasks;
        }

        # 할 일 추가.
        public function addTask($task, $author_id_uniq) {
            $query = "INSERT INTO $this->tableName (task, author_id_uniq) VALUES (?, ?)";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('ss', $task, $author_id_uniq);
            $stmt->execute();

            return true;
        }

        # 할 일 삭제.
        public function deleteTask($id) {
            $query = "DELETE FROM $this->tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('i', $id);
            $stmt->execute();

            return true;
        }

        # 완료로 표시.
        public function flipDone($id) {
            $task = $this->getTaskById($id);
            $newIsDone = $task['is_done'] ? 0 : 1;

            $query = "UPDATE $this->tableName SET is_done = $newIsDone WHERE id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('i', $id);
            $stmt->execute();

            return true;
        }
    }
?>