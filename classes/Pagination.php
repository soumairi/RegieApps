<?php
class Pagination{
	
	private  $data;
	
	public function page($data,$par_page){

		$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
		$total_data=count($data);
		if(isset($get['id'])){
			$page=explode('s',$get['id']);
			$current_page=(int)$page['0'];
		}else {
			$current_page=1;
		}
		$total_page=ceil($total_data/$par_page);
		$start=($current_page-1)*$par_page;
		$this->data=array_slice($data,$start,$par_page);
		for($i=1; $i<= $total_page; $i++)
		{
			$numbers[]=$i;
		}
		return $numbers;
		
	}
	public function getData(){
		return $this->data;
	}
	
}