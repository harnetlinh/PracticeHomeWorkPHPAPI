<?php

/**
 * User
 */
class User {

	private $conn = null;
	const userTable = 'users';
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $db = new Database();
		$this->conn = $db->getConnection();
    }	
	/**
	 * update user
	 *
	 * @param  int $id
	 * @param  string $name
	 * @param  string $phone
	 * @param  string $avatar
	 * @return bool
	 */
	public function update($id, $name, $phone, $avatar){
		// TODO create function update user
        // return true | false;
	}	
	/**
	 * delete user
	 *
	 * @param  int $id
	 * @return bool
	 */
	public function delete($id){
		// TODO create function delete user
        // return true | false;
	}
	/**
	 * create new user in database
	 *
	 * @param  string $name
	 * @param  string $phone
	 * @param  string $avatar
	 * @return bool
	 */
	public function create($name, $phone, $avatar){
		try {
			$stmt = $this->conn->prepare("
			INSERT INTO ".self::userTable." (`name`, `phone`, `avatar`) VALUES( ? , ? , ? )");

			
			if ($stmt == false) {
				return false;
			 } else {
				$params = [$name,$phone,$avatar];
				$stmt->execute($params);
				if($stmt->rowCount()){
					return true;
				}else{
					return false;
				}
			 }
		
			return false;	
		} catch (\Throwable $th) {
			error_log($th);
			return false;
		}
	}	
	/**
	 * get full information of user from database
	 *
	 * @param  string $name default NULL
	 * @param  string $phone default NULL
	 * @return mixed ['result' => mixed, 'error' => 0|1]
	 */
	public function getInfo($name = null, $phone = null){
		try {
		
			if ($name == null || $name == '') {
				$name = '';
			}
			$name = '%'.$name.'%';
			if ($phone == null || $phone == ''|| $phone == 0) {
				$phone = '';
			}
			$phone = '%'.$phone.'%';
			$stmt = $this->conn->prepare("SELECT * FROM ".self::userTable." WHERE `name` like ? and `phone` like ?");
			if ($stmt == false) {
				return ['result' => [], 'error' => ""];
			 } else {
				$params = [];
				array_push($params,$name,$phone);
				$stmt->execute($params);
				$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				return ['result' => json_encode($result), 'error' => 0];
			 }
			
		} catch (\Throwable $th) {
			error_log($th);
			return ['result' => [], 'error' => $th];
		}
	}
}

?>