<!-- 사용자 리포지토리 클래스 -->

<?php
    class UserRepo {
        private $connection;
        private $tableName;

        public function __construct($connection) {
            $this->connection = $connection;
            $this->tableName = 'user';
        }

        # 사용자 아이디로 사용자 불러오기.
        public function getUserById($id) {
            $query = "SELECT * FROM $this->tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('s', $id);
            $stmt->execute();

            $result = $stmt->get_result();

            $user = mysqli_fetch_array($result);

            return $user;
        }

        # 사용자 추가.
        public function addUser($userName, $passwd) {
            $query = "SELECT * FROM $this->tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('s', $userName);
            $stmt->execute();

            $result = $stmt->get_result();

            if (mysqli_num_rows($result) > 0) {
                return false;
            }

            $query = "INSERT INTO $this->tableName (id, passwd) VALUES (?, ?)";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('ss', $userName, $passwd);
            $stmt->execute();

            return true;
        }

        # 사용자 삭제.
        public function deleteUser($userName) {
            $query = "DELETE FROM $this->tableName WHERE id = ?";
            $stmt = $this->connection->prepare($query);

            $stmt->bind_param('s', $userName);
            $stmt->execute();

            return true;
        }
    }
?>