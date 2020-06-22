<?php
@include_once "../model/Person.php";
@include_once "../model/Login.php";

function insertPerson(Person $person)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $findPerson = "SELECT user_name from person where user_name = '" . $person->getUsername() . "'";
    $result = mysqli_query($connection, $findPerson);
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['user_name'];
    }
    if ($username == $person->getUsername()) {
        return -1;
    } else {
        $query = "INSERT INTO person ( user_name, name, email, phone, password, address, status) 
        VALUES (
            '" . $person->getUsername() . "' ,
        '" . $person->getName() . "' , 
        '" . $person->getEmail() . "', 
        '" . $person->getPhone() . "', 
        '" . password_hash($person->getPassword(), PASSWORD_DEFAULT) . "', 
        '" . $person->getAddress() . "',
        1
        )";
        if (mysqli_query($connection, $query)) {
            return 1;
        } else {
            return 0;
        }
    }

    mysqli_close($connection);
}

function insertVendor(Person $person)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $findPerson = "SELECT user_name from person where user_name = '" . $person->getUsername() . "'";
    $result = mysqli_query($connection, $findPerson);
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['user_name'];
    }
    if ($username == $person->getUsername()) {
        return -1;
    } else {
        $query = "INSERT INTO person ( user_name, name, email, phone, password, address, status) 
        VALUES ('" . $person->getUsername() . "' ,'" . $person->getName() . "' , '" . $person->getEmail() . "', '" . $person->getPhone() . "', '" . password_hash($person->getPassword(), PASSWORD_DEFAULT) . "', '" . $person->getAddress() . "',2)";
        if (mysqli_query($connection, $query)) {
            return 1;
        } else {
            return 0;
        }
    }

    mysqli_close($connection);
}



function loginPerson(Login $login)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * from person where user_name = '" . $login->getUsername() . "'";
    $statement = $connection->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result;
    } else {
        return null;
    }
    mysqli_close($connection);
}

function updatePerson(Person $person)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "update person set name = '" . $person->getName() . "' , email = '" . $person->getEmail() . "', phone = '" . $person->getPhone() . "',address = '" . $person->getAddress() . "' where user_name = '" . $person->getUsername() . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}
function updatePassword($username, $newPassword)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "update person set password = '" . password_hash($newPassword, PASSWORD_DEFAULT) . "'  where user_name = '" . $username . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}
function getAllCustomer()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from person where status = 1";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function getAllVendor()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from person where status = 2";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}


function insertAdmin(Person $person)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }

    $query = "INSERT INTO person ( user_name, name, email, phone, password, address, status) 
        VALUES ('" . $person->getUsername() . "' ,'" . $person->getName() . "' , '" . $person->getEmail() . "', '" . $person->getPhone() . "', '" . password_hash($person->getPassword(), PASSWORD_DEFAULT) . "', '" . $person->getAddress() . "',0)";
    if (mysqli_query($connection, $query)) {
        return 1;
    } else {
        return 0;
    }

    mysqli_close($connection);
}
