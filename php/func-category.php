<?php
# Get all categories from the database
function get_all_category($con) {
    $sql = "SELECT * FROM categories";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $categories = $stmt->fetchAll();
    } else {
        $categories = 0;
    }

    return $categories;
}

# Get category from the database by id
function get_category($con, $id) {
    $sql = "SELECT * FROM categories WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0) {
        $category = $stmt->fetch();
    } else {
        $category = 0;
    }

    return $category;
}