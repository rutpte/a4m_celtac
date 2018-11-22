<?php
require_once dirname(__FILE__) . '/includes/init.inc.php';
//header('Content-type: application/json');
$list_data_class = new ListData($pdo);


$case = isset($_GET['action']) ? $_GET['action'] : '';
$callback = isset($_GET["callback"]) ? $_GET["callback"] : false;
//-------------------------------------------------------------------

function jsonCrossDomain ($callback, $result) {
    header('Content-type: application/json');
    if($callback) {
        echo "$callback(";
    }

    echo json_encode($result);

    if($callback) {
        echo ")";
    } 
}

//-------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "GET") { 
    //var_dump($_GET);exit;
    $id		   = isset($_GET["id"]) ? trim($_GET["id"]) : "";                 //--> for del
    $q         = isset($_GET["q"]) ? trim($_GET["q"]) : "";                 //--> grid
    $query     = isset($_GET["query"]) ? trim($_GET["query"]) : "";         //-->word search
    $callback  = isset($_GET["callback"]) ? $_GET["callback"] : false;
    $limit     = isset($_GET["limit"]) ? $_GET["limit"] : 30;
    $start     = isset($_GET["start"]) ? $_GET["start"] : 0;
    $sort      = isset($_GET["sort"]) ? $_GET["sort"] : false;
    $dir       = isset($_GET["dir"]) ? $_GET["dir"] : "ASC";

    switch(strtolower($_GET["q"])) {
        case "grid" :
            
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();
                        $result = $list_data_class->search_data($query,$start,$limit,$sort,$dir);
                    $pdo->commit();
                    //var_dump($result);exit;
                    jsonCrossDomain ($callback, $result);
                } catch (Exception $e) {
                    $pdo->rollBack();
//                         header("HTTP/1.1 404 Not Found");
                    echo "error::: " . $e->getMessage();
                }
            break;
        case "delete" : //--> from ajax
            //var_dump($id); exit;
			try {
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->beginTransaction();
					$result = $list_data_class->delete_data($id);
				$pdo->commit();
				//var_dump($result);exit;
				jsonCrossDomain ($callback, $result);
			} catch (Exception $e) {
				$pdo->rollBack();
//                         header("HTTP/1.1 404 Not Found");
				echo "error::: " . $e->getMessage();
			}
		break;
		
	}

} else if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
    if (isset($_POST["q"])) {

		$q  = isset($_POST["q"]) ? trim($_POST["q"]) : "";
        switch(strtolower($_POST["q"])) {
            case "insert" :
				try {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pdo->beginTransaction();
						$result = $list_data_class->insert_data($_POST);
					$pdo->commit();
					//var_dump($result);exit;
					echo json_encode($result);
					//jsonCrossDomain ($callback, $result);
				} catch (Exception $e) {
					$pdo->rollBack();
	//                         header("HTTP/1.1 404 Not Found");
					echo "error::: " . $e->getMessage();
				}
			break;
			//------------------
            case "update" :
				try {
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pdo->beginTransaction();
						$result = $list_data_class->update_data($_POST);
					$pdo->commit();
					//var_dump($result);exit;
					//jsonCrossDomain ($callback, $result);
					echo json_encode($result);
				} catch (Exception $e) {
					$pdo->rollBack();
	//                         header("HTTP/1.1 404 Not Found");
					echo "error::: " . $e->getMessage();
				}
			break;
        }
    }
}