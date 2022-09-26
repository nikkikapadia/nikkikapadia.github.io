<?php

// database functions
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('connect.php');

// helper function used internally to test output
function dd($value)
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

// takes a sql command and data, then executes the command 
function executeQuery($sql, $data)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    echo $conn -> error;
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}

// selects all data from a given table
function selectAll($table, $conditions = [])
{
    global $conn;
    $sql = "SELECT * FROM $table";
    if (empty($conditions))
    {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
    else
    {
        //return records that match conditions
        $i = 0;
        foreach ($conditions as $key => $value)
        {
            if ($i === 0)
            {
                $sql = $sql . " WHERE $key=?";
            }
            else
            {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }


        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }

}

// selects one element from a table, given conditions
function selectOne($table, $conditions)
{
    global $conn;
    $sql = "SELECT * FROM $table";


    $i = 0;
    foreach ($conditions as $key => $value)
    {
        if ($i === 0)
        {
            $sql = $sql . " WHERE $key=?";
        }
        else
        {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";

    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_assoc();
    return $records;
}

// creates an entry into a table with the given data
function create($table, $data)
{
    global $conn;
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value)
    {
        if ($i === 0)
        {
            $sql = $sql . " $key=?";
        }
        else
        {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

// updates a database field
function update($table, $id, $data)
{
    global $conn;
    //  $sql = "UPDATE users SET username=?, password=? WHERE id=?"
    $sql = "UPDATE $table SET ";

    $i = 0;
    foreach ($data as $key => $value)
    {
        if ($i === 0)
        {
            $sql = $sql . " $key=?";
        }
        else
        {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}

// deletes a database field
function delete($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";

    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
}
