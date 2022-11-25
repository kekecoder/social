<?php
require_once 'dbconfig.php';

function insert(string $story, $img = "", $user_id)
{
    $conn = db();
    $query = $conn->prepare("INSERT INTO stories(story, image_path, user_id, created_at) VALUES(?, ?, ?,'NOW()');");
    $query->bind_param("ssi", $story, $img, $user_id);
    $query->execute();

    return $query;
}

function update_story($id, $story)
{
    $conn = db();
    $query = $conn->prepare("UPDATE stories SET story = ? WHERE id = ?");
    $query->bind_param("si", $story, $id);
    $query->execute();

    return $query;
}

function get_all_story()
{
    $conn = db();
    $query = "SELECT * FROM stories ORDER BY created_at DESC";
    $result = $conn->query($query);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_story_id($id)
{
    $conn = db();
    $query = "SELECT * FROM stories WHERE id = $id";
    $result = mysqli_query($conn, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
}
function user_id($id)
{
    $conn = db();
    $query = "SELECT user_id FROM stories WHERE id = $id";
    $result = mysqli_query($conn, $query);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function delete_story($id)
{
    $conn = db();
    $query = $conn->prepare("DELETE FROM stories WHERE id = ?");
    $query->bind_param('i', $id);
    return $query->execute();
}