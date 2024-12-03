<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'components/link.php' ?>
    <title>YeoFlix</title>
</head>

<body>
    <?php include 'components/headerAdmin.php'; ?>

    <div class="sidebar">
        <a href="index.html" class="sidebar__logo"></a>
        <?php include 'components/sidebar.php'; ?>
    </div>

    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="main__title">
                        <h2>Movies</h2>

                        <div class="main__title-wrap">
                            <a href="add-item.php" class="main__title-link main__title-link--wrap">Add Film</a>
                            <form action="#" id="search" class="main__title-form">
                                <input type="text" id="search-input" placeholder="Find movie / tv series.." autocomplete="off">
                                <button type="button"></button>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- end main title -->

                <!-- items -->
                <div class="col-12">
                    <div class="catalog catalog--1">
                        <table class="catalog__table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TITLE</th>
                                    <th>CATEGORY</th>
                                    <th>DURATION</th>
                                    <th>RELEASE DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include '../koneksi.php';
                                $no = 1;
                                $sql = "SELECT * FROM movies"; 
                                $result = mysqli_query($conn, $sql);

                                if (!$result) {
                                    die("Query Error: " . mysqli_error($conn));
                                }

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <input type="hidden" name="id" value="<?= $row['movie_id'] ?>"> 
                                        <td>
                                            <div class="catalog__text"><?= $no; ?></div>
                                        </td>
                                        <td>
                                            <div class="catalog__text"><a href="#"><?= $row['title'] ?></a></div> 
                                        </td>
                                        <td>
                                            <div class="catalog__text"><?= $row['category'] ?></div> 
                                        </td>
                                        <td>
                                            <div class="catalog__text"><?= $row['duration'] ?> min</div> 
                                        </td>
                                        <td>
                                            <div class="catalog__text"><?= $row['release_date'] ?></div> 
                                        </td>
                                        <td>
                                            <div class="catalog__text <?= $row['status'] === "Visible" ? "catalog__text--green" : "catalog__text--red" ?>"><?= $row['status'] ?></div>
                                        </td>
                                        <td>
                                            <div class="catalog__btns">
                                                <a href="edit_film.php?id=<?= $row['movie_id'] ?>" class="catalog__btn catalog__btn--edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="#" onclick="confirmDelete(<?= $row['movie_id'] ?>)" class="catalog__btn catalog__btn--delete">
                                                    <i class="bi bi-trash3"></i>
                                                </a>

                                                <script>
                                                    function confirmDelete(filmId) {
                                                        const isConfirmed = confirm("Apakah Anda yakin ingin menghapus film ini?");
                                                        if (isConfirmed) {
                                                            window.location.href = "hapusfilm.php?id=" + filmId;
                                                        }
                                                    }
                                                </script>

                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    
    <div class="modal fade" id="modal-status" tabindex="-1" aria-labelledby="modal-status" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal__content">
                    <form action="#" class="modal__form">
                        <h4 class="modal__title">Status change</h4>
                        <p class="modal__text">Are you sure about immediately change status?</p>
                        <div class="modal__btns">
                            <button class="modal__btn modal__btn--apply" type="button"><span>Apply</span></button>
                            <button class="modal__btn modal__btn--dismiss" type="button" data-bs-dismiss="modal" aria-label="Close"><span>Dismiss</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-delete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal__content">
                    <form action="#" class="modal__form">
                        <h4 class="modal__title">Item delete</h4>
                        <p class="modal__text">Are you sure to permanently delete this item?</p>
                        <div class="modal__btns">
                            <button class="modal__btn modal__btn--apply" type="button"><span>Delete</span></button>
                            <button class="modal__btn modal__btn--dismiss" type="button" data-bs-dismiss="modal" aria-label="Close"><span>Dismiss</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/slimselect.min.js"></script>
    <script src="js/smooth-scrollbar.js"></script>
    <script src="js/admin.js"></script>

    <script>
        $(document).ready(function() {
            $('#search-input').on('input', function() {
                var query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: 'search.php',
                        type: 'POST',
                        data: {
                            search: query
                        },
                        success: function(data) {
                            $('tbody').html(data);
                        }
                    });
                } else {
                    $.ajax({
                        url: 'search.php',
                        type: 'POST',
                        data: {
                            search: ''
                        },
                        success: function(data) {
                            $('tbody').html(data);
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>