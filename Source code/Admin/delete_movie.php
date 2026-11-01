<?php
session_start();
include_once "../includes/db.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $movie_id = intval($_GET['id']);
    $select_query = "SELECT poster FROM movies WHERE id = $movie_id";
    $result = mysqli_query($connect, $select_query);

    if (mysqli_num_rows($result) > 0) {
        $movie = mysqli_fetch_assoc($result);
        $poster_path = "../" . $movie['poster'];
        if (!empty($movie['poster']) && file_exists($poster_path)) {
            unlink($poster_path);
        }
        $delete_query = "DELETE FROM movies WHERE id = $movie_id";
        if (mysqli_query($connect, $delete_query)) {
            echo "<script> alert('Movie deleted successfully!'); window.location.href = 'movie.php';</script>";
            exit();
        } else {
            echo "<script> alert('Error deleting movie: " . mysqli_error($connect) . "'); window.location.href = 'movie.php';</script>";
            exit();
        }
    } else {
        echo "<script> alert('Movie not found!'); window.location.href = 'movie.php'; </script>";
        exit();
    }
} else {
    header("Location: movie.php");
    exit();
}
?>