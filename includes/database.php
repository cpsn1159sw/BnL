<!-- Các hàm xử lí liên quan đến CSDL -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

function query($sql, $data=[], $check = false) {
    global $conn;
    $result = false;
    try{
        $statement = $conn->prepare($sql);

        if(!empty($data)) {
            $result = $statement->execute($data);
        } else {
            $result = $statement->execute();
        }
    } catch(Exception $exp) {
        echo $exp->getMessage(). '<br>';
        echo 'File: '. $exp->getFile(). '<br>';
        echo 'Line: '. $exp->getLine();
        die();
    }

    if($check) {
        return $statement;
    }
    return $result;
}

function insert($table, $data) {
    $key = array_keys($data);
    $attribute = implode(',', $key);
    $valuetb = ':'. implode(',:', $key);

    $sql = 'INSRT INTO'. $table. '('.$attribute.')'. 'VALUES('. $valuetb. ')';
    query($sql, $data);
    $result = query($sql, $data);
    return $result;
}

function update($table, $data, $condition='') {
    $result = false;
    $update = '';
    foreach($data as $key => $value) {
        $update.= $key. '= :'. $key. ',';
    }
    $update = trim($update,',');

    if(!empty($condition)) {
        $sql = 'UPDATE '. $table. ' SET '. $update. ' WHERE '. $condition;
    } else {
        $sql = 'UPDATE '. $table. ' SET '. $update ;
    }

    $result = query($sql, $data);
    return $result;
}

function delete($table, $condition='') {
    if(!empty($condition)) {
        $sql = 'DELETE FROM '. $table;
    } else {
        $sql = 'DELETE FROM '. $table. ' WHERE '.$condition;
    }

    $result = query($sql);
    return $result;
}

// Lấy nhiều dòng dữ liệu 
function getRows($sql) {
    $result = query($sql, '', true);
    if(is_object($result)) {
        $dataFetch = $result -> fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Lấy một dòng dữ liệu 
function oneRow($sql) {
    $result = query($sql, '', true);
    if(is_object($result)) {
        $dataFetch = $result -> fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Đếm số dòng dữ liệu 
function countRows($sql) {
    $result = query($sql, '', true);
    if(!empty($result)) {
        return $result -> rowCount();
    }
}