<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include 'components/link.php' ?>
</head>

<body>
    <div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="modal-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal__content">
                    <form action="#" class="modal__form">
                        <h4 class="modal__title">Add User</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="sign__group">
                                    <label class="sign__label" for="email0">Email</label>
                                    <input id="email0" type="text" name="email" class="sign__input">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="sign__group">
                                    <label class="sign__label" for="pass0">Password</label>
                                    <input id="pass0" type="password" name="pass0" class="sign__input">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="sign__group">
                                    <label class="sign__label" for="subscription">Subscription</label>
                                    <select class="sign__select" id="subscription">
                                        <option value="Basic">Basic</option>
                                        <option value="Premium">Premium</option>
                                        <option value="Cinematic">Cinematic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="sign__group">
                                    <label class="sign__label" for="rights">Rights</label>
                                    <select class="sign__select" id="rights">
                                        <option value="User">User</option>
                                        <option value="Moderator">Moderator</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 offset-lg-3">
                                <button type="button" class="sign__btn sign__btn--modal">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
