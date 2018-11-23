<?php

class ListData extends DBConnection
{
    /**
     * __construct — Initialization
     *
     * @return No value is returned.
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
//         $foobar = new DBConnection;  // correct
//         $foobar->__construct($pdo);
    }
//-----------------------------------------

    public function search_data($query,$start,$limit,$sort,$dir)
    {
	$sql_total ="
        select count(id) from customer
        where 1=1
        AND(
			(lower(_no)LIKE LOWER('%{$query}%'))
			OR (lower(title) LIKE LOWER('%{$query}%') )
			OR (lower(name) LIKE LOWER('%{$query}%'))
			OR (lower(surname) LIKE LOWER('%{$query}%'))
			OR (lower(address1) LIKE LOWER('%{$query}%'))
			OR (lower(address2) LIKE LOWER('%{$query}%'))
			OR (lower(region) LIKE LOWER('%{$query}%'))
			OR (lower(phone) LIKE LOWER('%{$query}%'))
			OR (lower(mphone) LIKE LOWER('%{$query}%'))
			OR (lower(email) LIKE LOWER('%{$query}%'))
			OR (lower(currency) LIKE LOWER('%{$query}%'))
			OR (lower(payment_by) LIKE LOWER('%{$query}%'))
			OR (lower(payment_method) LIKE LOWER('%{$query}%'))
			OR (lower(payment_process) LIKE LOWER('%{$query}%'))
			OR (lower(remark) LIKE LOWER('%{$query}%'))
		)
    ";
	//----------
    $sql ="
        select * from customer
        where 1=1
        AND(
			(lower(_no)LIKE LOWER('%{$query}%'))
			OR (lower(title) LIKE LOWER('%{$query}%') )
			OR (lower(name) LIKE LOWER('%{$query}%'))
			OR (lower(surname) LIKE LOWER('%{$query}%'))
			OR (lower(address1) LIKE LOWER('%{$query}%'))
			OR (lower(address2) LIKE LOWER('%{$query}%'))
			OR (lower(region) LIKE LOWER('%{$query}%'))
			OR (lower(phone) LIKE LOWER('%{$query}%'))
			OR (lower(mphone) LIKE LOWER('%{$query}%'))
			OR (lower(email) LIKE LOWER('%{$query}%'))
			OR (lower(currency) LIKE LOWER('%{$query}%'))
			OR (lower(payment_by) LIKE LOWER('%{$query}%'))
			OR (lower(payment_method) LIKE LOWER('%{$query}%'))
			OR (lower(payment_process) LIKE LOWER('%{$query}%'))
			OR (lower(remark) LIKE LOWER('%{$query}%'))
		)
    ";
        if($sort) {
            $sql .= ' ORDER BY '.$sort;
            $sql .= strtoupper($dir)=='ASC'?' ASC':' DESC';
        }
        $sql .= " LIMIT {$limit} OFFSET {$start}";
//echo '<pre>'; echo $sql_total; exit;
//echo '<pre>'; echo $sql; exit;
//------------
        //echo '<pre>'; echo $sql; exit;
		
        $sth 		= $this->db->prepare($sql);
		
        
        try {
			
            $sth->execute();

            $result = Array();
            $result["items"] = $sth->fetchAll(PDO::FETCH_CLASS);
            $result["total"] = $this->db->query($sql_total)->fetchObject()->count;
			//var_dump($result["total"]);//s
        return $result;
        } catch (Exception $e) {
            echo "ERROR : sql";
            print_r($sth->errorInfo());
            exit;
        }
    }
	//------------------------------------------------------------------------
	
    public function delete_data($id)
    {
    $sql ="
        delete from customer
        where id = {$id}
    ";
	$sth = $this->db->prepare($sql);
		
        
        try {
			
            $sth->execute();

            $result = Array();
            $result["success"] = true;
        return $result;
        } catch (Exception $e) {
            echo "ERROR : sql";
            print_r($sth->errorInfo());
            exit;
        }
	}
	//------------------------------------------------------------------------
	
    public function insert_data($post)
    {
		 //var_dump($post);exit;
		$_no_data 				= str_replace("'","\'",$post['_no_data']);
		$title_data 			= str_replace("'","\'",$post['title_data']);
		$name_data 				= str_replace("'","\'",$post['name_data']);
		$surname_data 			= str_replace("'","\'",$post['surname_data']);
		$address1_data 			= str_replace("'","\'",$post['address1_data']);
		$address2_data 			= str_replace("'","\'",$post['address2_data']);
		$region_data 			= str_replace("'","\'",$post['region_data']);
		$phone_data 			= str_replace("'","\'",$post['phone_data']);
		$mphone_data 			= str_replace("'","\'",$post['mphone_data']);
		$email_data 			= str_replace("'","\'",$post['email_data']);
		$amount_data 			= $post['amount_data'];
		$currency_data 			= str_replace("'","\'",$post['currency_data']);
		//$registration_date_data = TO_DATE('{$post['registration_date_data']}', 'DD/MM/YYYY');
		//$payment_date_data 		= TO_DATE('{$post['payment_date_data']}', 'DD/MM/YYYY');
		$payment_by_data 		= str_replace("'","\'",$post['payment_by_data']);
		$payment_method_data 	= str_replace("'","\'",$post['payment_method_data']);
		$payment_process_data 	= str_replace("'","\'",$post['payment_process_data']);
		$status_data 			= $post['status_data'];
		$remark_data 			= str_replace("'","\'",$post['remark_data']);
		//---------------------------------------------------------------------
		$sql ="
			insert into customer
			(       _no 				
                    ,title				
                    ,name				
                    ,surname			
                    ,address1			
                    ,address2			
                    ,region			
                    ,phone				
                    ,mphone			
                    ,email				
                    ,amount			
                    ,currency			
                    ,registration_date	
                    ,payment_date		
                    ,payment_by		
                    ,payment_method	
                    ,payment_process	
                    ,status			
                    ,remark
			)
			values(
				'{$_no_data}',
				'{$title_data}',
				'{$name_data}',
				'{$surname_data}',
				'{$address1_data}',
				'{$address2_data}',
				'{$region_data}',
				'{$phone_data}',
				'{$mphone_data}',
				'{$email_data}',
				{$amount_data},
				'{$currency_data}',
				TO_DATE('{$post['registration_date_data']}', 'DD/MM/YYYY'),
				TO_DATE('{$post['payment_date_data']}', 'DD/MM/YYYY'),
				'{$payment_by_data}',
				'{$payment_method_data}',
				'{$payment_process_data}',
				'{$status_data}',
				'{$remark_data}'
			)
		";
		//echo '<pre>'; echo $sql; exit;
		$sth = $this->db->prepare($sql);
		try {
			
			$sth->execute();

			$result = Array();
			$result["success"] = true;
			return $result;
		} catch (Exception $e) {
			echo "ERROR : sql";
			print_r($sth->errorInfo());
			exit;
		}
	}
	//------------------------------------------------------------------------
	
    public function update_data($data)
    {
		$_no_data 				= str_replace("'","\'",$data['_no_data']);
		$title_data 			= str_replace("'","\'",$data['title_data']);
		$name_data 				= str_replace("'","\'",$data['name_data']);
		$surname_data 			= str_replace("'","\'",$data['surname_data']);
		$address1_data 			= str_replace("'","\'",$data['address1_data']);
		$address2_data 			= str_replace("'","\'",$data['address2_data']);
		$region_data 			= str_replace("'","\'",$data['region_data']);
		$phone_data 			= str_replace("'","\'",$data['phone_data']);
		$mphone_data 			= str_replace("'","\'",$data['mphone_data']);
		$email_data 			= str_replace("'","\'",$data['email_data']);
		$amount_data 			= $data['amount_data'];
		$currency_data 			= str_replace("'","\'",$data['currency_data']);
		$payment_by_data 		= str_replace("'","\'",$data['payment_by_data']);
		$payment_method_data 	= str_replace("'","\'",$data['payment_method_data']);
		$payment_process_data 	= str_replace("'","\'",$data['payment_process_data']);
		$status_data 			= $data['status_data'];
		$remark_data 			= str_replace("'","\'",$data['remark_data']);

		$sql ="
			update customer
			set 
                    _no 				= '{$_no_data}',
                    title				= '{$title_data}',
                    name				= '{$name_data}',
                    surname				= '{$surname_data}',
                    address1			= '{$address1_data}',
                    address2			= '{$address2_data}',
                    region				= '{$region_data}',
                    phone				= '{$phone_data}',
                    mphone				= '{$mphone_data}',
                    email				= '{$email_data}',
                    amount				= '{$amount_data}',
                    currency			= '{$currency_data}',
                    registration_date	= TO_DATE('{$data['registration_date_data']}', 'DD/MM/YYYY'),
                    payment_date		= TO_DATE('{$data['payment_date_data']}', 'DD/MM/YYYY'),
                    payment_by			= '{$payment_by_data}',
                    payment_method		= '{$payment_method_data}',
                    payment_process		= '{$payment_process_data}',
                    status				= '{$status_data}',
                    remark				= '{$remark_data}'
			where id = '{$data['id_data']}'
		";
		
		//echo '<pre>'; echo $sql; exit;
		$sth = $this->db->prepare($sql);
		try {
			
			$sth->execute();

			$result = Array();
			$result["success"] = true;
			return $result;
		} catch (Exception $e) {
			echo "ERROR : sql";
			print_r($sth->errorInfo());
			exit;
		}
	}
	
    //---------------------------------------------------
    public function __destruct()
    {
        parent::__destruct();
    }
}