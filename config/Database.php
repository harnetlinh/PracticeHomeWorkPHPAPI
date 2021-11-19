<?php
class Database{
	
	private $host  = null;
    private $user  = null;
    private $password   = null;
    private $database  = null; 
	private $port = null;
	private $charset = null;
        
    	
	/**
	 * __construct load value from .env
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->host  = $_ENV['DB_HOST'];
		$this->user  = $_ENV['DB_USER'];
		$this->password  = $_ENV['DB_PASSWORD'];
		$this->database  = $_ENV['DB_DATABASE_NAME'];
		$this->port  = $_ENV['DB_PORT'];
		$this->charset  = $_ENV['DB_CHARSET'];

	}
	/**
     * get Connection
     *
     * @return PDO $connection
     */
    public function getConnection(){
		$conn = new \PDO(
			"mysql:host=".$this->host.";port=".$this->port.";charset=".$this->charset.";dbname=".$this->database,
			$this->user,
			$this->password
		);
		if($conn->connect_error){
			error_log("Error failed to connect to MySQL: " . $conn->connect_error);
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}
?>