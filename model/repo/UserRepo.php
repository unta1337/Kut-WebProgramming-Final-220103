<!-- Repository Class -->

<?php
    class UserRepo {
        private $connection;
        private $tableName;

        public function __construct($connection) {
            $this->connection = $connection;
            $this->tableName = 'user';
        }

        public function getUsers() {
            $query = "SELECT * FROM $this->tableName";
            $result = mysqli_query($this->connection, $query);

            $users = [];
            while ($row = mysqli_fetch_array($result)) {
                array_push($users, $row);
            }

            return $users;
        }

        public function getUserById($id) {
            $query = "SELECT * FROM $this->tableName WHERE id = '$id'";
            $result = mysqli_query($this->connection, $query);

            $user = mysqli_fetch_array($result);

            return $user;
        }

        public function getUserInfoByIdUniq($idUniq) {
            $query = "SELECT * FROM $this->tableName WHERE id_uniq = $idUniq";
            $result = mysqli_query($this->connection, $query);

            $user = [];
            while ($row = mysqli_fetch_array($result)) {
                array_push($user, $row);
            }

            return $user[0];
        }

        public function addUser($userName, $passwd) {
            $query = "SELECT * FROM $this->tableName WHERE id = '$userName'";
            $result = mysqli_query($this->connection, $query);

            if (mysqli_num_rows($result) > 0) {
                return false;
            }

            $query = "INSERT INTO $this->tableName (id, passwd) VALUES ('$userName', '$passwd')";
            $result = mysqli_query($this->connection, $query);

            return true;
        }
    }
?>