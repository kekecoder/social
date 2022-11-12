<?php
require_once 'dbconfig.php';

function insert(string $story, $date, $img = "")
{
    $conn = db();
    $query = $conn->prepare("INSERT INTO stories(story, image_path, created_at) VALUES(?, ?, '$date');");
    $query->bind_param("ss", $story, $img);
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

function delete_story($id)
{
    $conn = db();
    $query = $conn->prepare("DELETE FROM stories WHERE id = ?");
    $query->bind_param('i', $id);
    return $query->execute();
}