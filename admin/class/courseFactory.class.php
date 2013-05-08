<?php
/*
created: 18/4 1313 Jeremiah 
last edited 29/4 1313 Jeremiah

purpose: course factory

*/
class CourseFactory
{
	public static function addCourse($course)
	{
		$id = strtoupper($course->id);
		
		$query = "INSERT INTO courses VALUES( '$id','$course->name','$course->require',$course->age,$course->fee,$course->session,'$course->duration','$course->day','$course->time')";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		return $course->id;
			
	}
	
	public static function getAllCourse()
	{
		$query = "SELECT * FROM courses";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		$courseArray = array();
		while($curCourse = mysqli_fetch_assoc($answer))
		{
			$course = new Course();
			foreach($curCourse as $key => $value)
			{
				if($key == 'id')
				{
					$course->id = $value;
				}
				else
				{
					$key = substr($key, 7);	
					$course->$key = $value;
				}
			}
			$courseArray[] = $course;
		}
		
		return $courseArray;
			
	}
	
	public static function getCourseById($id)
	{
		$query = "SELECT * FROM courses WHERE id = '$id'";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) echo false;
		
		$fetch_course = mysqli_fetch_assoc($answer);
		$course = new Course();
		foreach($fetch_course as $key=>$value)
		{
			if($key == 'id')
				{
					$course->id = $value;
				}
				else
				{
					$key = substr($key, 7);	
					$course->$key = $value;
				}	
		}
		$course = json_encode($course);
		print_r($course);
	}
	
	public static function deleteCourseById($id)
	{
		$query = "DELETE FROM courses WHERE id = '$id'";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return $query;
		
		return $answer;	
	}
	
		
}

?>