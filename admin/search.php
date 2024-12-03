<?php
include '../koneksi.php';

if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    
    $sql = "SELECT * FROM movies WHERE title LIKE '%$search%'"; 
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<input type="hidden" name="id" value="' . $row['movie_id'] . '">';
            echo '<td><div class="catalog__text">' . $no . '</div></td>';
            echo '<td><div class="catalog__text"><a href="#">' . $row['title'] . '</a></div></td>';
            echo '<td><div class="catalog__text">' . $row['category'] . '</div></td>';
            echo '<td><div class="catalog__text">' . $row['duration'] . ' min</div></td>';
            echo '<td><div class="catalog__text">' . $row['release_date'] . '</div></td>';
            echo '<td><div class="catalog__text catalog__text--green">Visible</div></td>';
            echo '<td><div class="catalog__btns">';
            echo '<a href="edit_film.php?id=' . $row['movie_id'] . '" class="catalog__btn catalog__btn--edit">';
            echo '<i class="bi bi-pencil-square"></i></a>';
            echo '<a href="#" onclick="confirmDelete(' . $row['movie_id'] . ')" class="catalog__btn catalog__btn--delete">';
            echo '<i class="bi bi-trash3"></i></a>';
            echo '</div></td>';
            echo '</tr>';
            $no++;
        }
    } else {
        echo '<tr><td colspan="7" style="color:white;text-align:center;">No results found</td></tr>';
    }
}
?>
