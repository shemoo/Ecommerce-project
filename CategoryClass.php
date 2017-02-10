<?php
require 'config.php';

class CategoryClass{
	private $cat_id;
	private $cat_name;
	private $parent;

	//Start of Constructor
	function __construct($cat_id,$cat_name,$parent=null){
		$this->cat_id=isset($this->cat_id)?$this->cat_id:$cat_id;
		$this->cat_name=isset($this->cat_name)?$this->cat_name:$cat_name;
		$this->parent=isset($this->parent)?$this->parent:$parent;
	}  //End of Constructor

	//Setter Function
	function __set($attr , $val){
		$this->$attr = $val;
	}

	//getter Function
	function __get($attr){
		return $this->$attr;
	}

	function insert(){
		$success = true;
		$conn = new mysqli(DBHOST , DBUSER , DBPASS, DBNAME);


		if($conn->connect_errno){
			echo "error connection to DB ".$conn->connect_error."<br>";
			$success = false;
		} //End of open connection

		$query = "insert into category (cat_id,cat_name,parent) values(?,?,?)";
		$statement = $conn->prepare($query);
		if(!$statement){
			echo "error preparing query : ".$conn->error."<br>";
			$success = false;
		}
		$result = $statement->bind_param("isi",$this->cat_id,$this->cat_name,$this->parent);
		if(!$result){
			echo "binding failed : ".$statement->error;
			$success = false;
		}//End of prepqring statement

		if(!$statement->execute()){
			echo "execution failed : ".$statement->error;
			$success=false;
		}// End of insert method

		$statement->close();
		$conn->close();
		return $success;

	}//End of Insert function

	static function getById($cat_id){
		$success = true;
		$conn = new mysqli(DBHOST , DBUSER , DBPASS, DBNAME);

		if($conn->connect_errno){
			echo "error connection to DB ".$conn->connect_error."<br>";
			$success = false;
		} //End of open connection
		else{
			echo "Connection Succeed";
		}

		$query = "select * from category where cat_id=?";
		$statement = $conn->prepare($query);
		if(!$statement){
			echo "error preparing query : ".$conn->error."<br>";
			$success = false;
		}
		else{
			echo "Preparing query succeed";
		}
		$result = $statement->bind_param("i",$cat_id);
		if(!$result){
			echo "binding failed : ".$statement->error;
			$success = false;
		}//End of prepqring statement

		if(!$statement->execute()){
			echo "execution failed : ".$statement->error;
			$success=false;
		}// End of insert method

		$result = $statement->get_result();
		$product = $result->fetch_object('CategoryClass',array('cat_id','cat_name','parent'));
		$statement->close();
		return $product;

	}//End of getById function

	static function getByName($cat_name){
		$success = true;
		$conn = new mysqli(DBHOST , DBUSER , DBPASS, DBNAME);

		if($conn->connect_errno){
			echo "error connection to DB ".$conn->connect_error."<br>";
			$success = false;
		} //End of open connection

		$query = "select * from category where cat_name=?";
		$statement = $conn->prepare($query);
		if(!$statement){
			echo "error preparing query : ".$conn->error."<br>";
			$success = false;
		}
		$result = $statement->bind_param("s",$cat_name);
		if(!$result){
			echo "binding failed : ".$statement->error;
			$success = false;
		}//End of prepqring statement

		if(!$statement->execute()){
			echo "execution failed : ".$statement->error;
			$success=false;
		}// End of insert method

		$result = $statement->get_result();
		$product = $result->fetch_object('CategoryClass',array('cat_id','cat_name','parent'));
		$statement->close();
		return $product;

	}//End of getByName function

	static function getAllCategories(){
		$success = true;
		$conn = new mysqli(DBHOST , DBUSER , DBPASS, DBNAME);

		if($conn->connect_errno){
			echo "error connection to DB ".$conn->connect_error."<br>";
			$success = false;
		} //End of open connection

		$query = "select * from category";
		$statement = $conn->prepare($query);
		if(!$statement){
			echo "error preparing query : ".$conn->error."<br>";
			$success = false;
		}

		if(!$statement->execute()){
			echo "execution failed : ".$statement->error;
			$success=false;
		}// End of insert method

		$result = $statement->get_result();
		$categories = [];
		$params = array('cat_id','cat_name','parent');
		while($category = $result->fetch_object('CategoryClass',$params)){
			$products[] = $category; 
		}

		$statement->close();
		$conn->close();
		return $products;
	}//End of allCategories function

	function delete(){
		$success = true;
		$conn = new mysqli(DBHOST , DBUSER , DBPASS, DBNAME);

		if($conn->connect_errno){
			echo "error connection to DB ".$conn->connect_error."<br>";
			$success = false;
		} //End of open connection

		$query = "delete from category where cat_id = ?";
		$statement = $conn->prepare($query);
		if(!$statement){
			echo "error preparing query : ".$conn->error."<br>";
			$success = false;
		}
		$result = $statement->bind_param("i",$this->cat_id);
		if(!$result){
			echo "binding failed : ".$statement->error;
			$success = false;
		}//End of prepqring statement

		if(!$statement->execute()){
			echo "execution failed : ".$statement->error;
			$success=false;
		}// End of insert method

		$statement->close();
		$conn->close();
		return $success;
	}//End of delete function

	function update(){
		$success = true;
		$conn = new mysqli(DBHOST , DBUSER , DBPASS, DBNAME);

		if($conn->connect_errno){
			echo "error connection to DB ".$conn->connect_error."<br>";
			$success = false;
		} //End of open connection

		$query = "update category set cat_name = ?,parent=? where cat_id=?";
		$statement = $conn->prepare($query);
		if(!$statement){
			echo "error preparing query : ".$conn->error."<br>";
			$success = false;
		}
		$result = $statement->bind_param("sii",$this->cat_name,$this->cat_id,$this->parent);
		if(!$result){
			echo "binding failed : ".$statement->error;
			$success = false;
		}//End of prepqring statement

		if(!$statement->execute()){
			echo "execution failed : ".$statement->error;
			$success=false;
		}// End of insert method

		$statement->close();
		$conn->close();
		return $success;
	}//End of update function

}


// $category = new CategoryClass(2,'ddd',1);
// if($category->insert()){
// 	echo $category->cat_name."Inserted Succssefully";
// }

// $category= CategoryClass::getByName('cars');
// var_dump($category);

// $category = CategoryClass::getAllCategories();
// var_dump($category);

// $category = CategoryClass::getById(2);
// $category->delete();
// if($category->delete()){
// 	echo $category->cat_name."deleted Successfully";
//  }

// $category = CategoryClass::getById(2);
// $category->cat_name = 'hhh';
// if($category->update()){
// 	echo "Succeed";
// }

?>