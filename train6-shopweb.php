<?php
    $servername = "172.16.2.113";
    $username = "root";
    $password = "12345678";
    $dbname = "users";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $itemarraylist =[];
    $storearray = [];
    if(isset($_POST['store_name'])){
        $store_name = $_POST['store_name'];
        if($store_name == 'all'){
            $sql = "select * from items
                    inner join store
                    on items.items_store_no = store.store_no";
        }else{
            $sql = "select * from items
                    inner join store
                    on items.items_store_no = store.store_no
                    where store.store_name = '$store_name'";
        }
        $data = mysqli_query($conn, $sql);
        if(mysqli_num_rows($data)!=0){
            for ($i=0; $i < mysqli_num_rows($data); $i++) {
                $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);  
                $itemarraylist[$i] = array("items_no" => $rs['items_no'],
                                        "items_name" => $rs['items_name'],
                                        "items_price" => $rs['items_price'],
                                        "items_store_no" => $rs['items_store_no'],
                                        "store_name" => $rs['store_name']);
            }
        }
        //撈商店列表
        $sql_store = "select store_name from store";
        $store_data = mysqli_query($conn, $sql_store);
        if(mysqli_num_rows($store_data)!=0){
            for ($i=0; $i < mysqli_num_rows($store_data); $i++) {
                $rs = mysqli_fetch_array($store_data,MYSQLI_ASSOC);  
                $storearray[$i] = array("store_name_list" => $rs['store_name']);
            }
        }
        echo json_encode(['store_data'=>$storearray, 'item_data'=>$itemarraylist]);
    }
    //商品delete
    if(isset($_POST['delete_no'])){
        $delete_no = $_POST['delete_no'];
        $sql = "delete from items where items_no = '$delete_no'";
        $data = mysqli_query($conn, $sql);
        echo json_encode("刪除成功");
    }
    //商品insert
    if(isset($_POST['item_name'])){
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $sql = "insert into items(items_name, items_price, items_store_no)
                values('$item_name', '$item_price', '1')";
        $data = mysqli_query($conn, $sql);
        echo json_encode("新增成功");

    }

?>