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
			OR (lower(amount) LIKE LOWER('%{$query}%'))
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
			OR (lower(amount) LIKE LOWER('%{$query}%'))
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
	
    public function insert_data($data)
    {
		//var_dump($data);exit;
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
				'{$data['_no_data']}',
				'{$data['title_data']}',
				'{$data['name_data']}',
				'{$data['surname_data']}',
				'{$data['address1_data']}',
				'{$data['address2_data']}',
				'{$data['region_data']}',
				'{$data['phone_data']}',
				'{$data['mphone_data']}',
				'{$data['email_data']}',
				'{$data['amount_data']}',
				'{$data['currency_data']}',
				'{$data['registration_date_data']}',
				'{$data['payment_date_data']}',
				'{$data['payment_by_data']}',
				'{$data['payment_method_data']}',
				'{$data['payment_process_data']}',
				'{$data['status_data']}',
				'{$data['remark_data']}'
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

		$sql ="
			update customer
			set 
                    _no 				= '{$data['_no_data']}',
                    title				= '{$data['title_data']}',
                    name				= '{$data['name_data']}',
                    surname				= '{$data['surname_data']}',
                    address1			= '{$data['address1_data']}',
                    address2			= '{$data['address2_data']}',
                    region				= '{$data['region_data']}',
                    phone				= '{$data['phone_data']}',
                    mphone				= '{$data['mphone_data']}',
                    email				= '{$data['email_data']}',
                    amount				= '{$data['amount_data']}',
                    currency			= '{$data['currency_data']}',
                    registration_date	= '{$data['registration_date_data']}',
                    payment_date		= '{$data['payment_date_data']}',
                    payment_by			= '{$data['payment_by_data']}',
                    payment_method		= '{$data['payment_method_data']}',
                    payment_process		= '{$data['payment_process_data']}',
                    status				= '{$data['status_data']}',
                    remark				= '{$data['remark_data']}'
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