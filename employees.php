<?php 
    class Employee{
        //connection
        private $conn;
        //table
        private $db_table = "Employee";
        //columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $created;
        //db connection
        public function __construct($db){
            $this->conn = $db;
        }
        //get all
        public function getEmployees() {
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM "
            . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        //create
        public function createEmployee(){
            $sqlQuery = "INSERT INTO 
                        ". $this->db_table ."
            SET 
                name = :name,
                email = :email,
                age = :age,
                designation = :designation,
                created = :created";

            $stmt = $this->conn->prepare($sqlQuery);

            //sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->created=htmlspecialchars(strip_tags($this->created));

            //bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":designation", $this->designation);
            $stmt->bindParam(":created", $this->created);

            if($stmt->execute()){
                return true;
            }
            return false;
        }
        //read single
        public function getSingleEmployee(){
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table ."
                        WHERE id = ? LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->created = $dataRow['created'];
        }
        //update
        public function updateEmployee(){
            $sqlQuery = "UPDATE ". $this->db_table .
            "SET 
                name = :name,
                email = :email,
                age = :age,
                designation = :designation,
                created = :created
            WHERE id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->created=htmlspecialchars(strip_tags($this->created));
            $this->id=htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":designation", $this->designation);
            $stmt->bindParam(":created", $this->created);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()){
                return true;
            }
            return false;
        }
        //delete
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID = ?";
            $stmt = $this->conn->prepare($sqlQuery);

            $this->id=htmlspecialchars(strip_tags($this->id));
            
            $stmt->bindParam(1, $this->id);

            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>