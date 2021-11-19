<?php
echo'<form action="'.$_SERVER['PHP_SELF']  .'" method="POST">
    <div class="row mt-3 g-3 justify-content-center">
        <div class="col-md-10">
            <fieldset>
                <div class="form-floating">
                    <input type="text" class="form-control" name="group_name" id="group_name"
                        placeholder="'. lang['groups'] .' '.  lang['name']  .'" required>
                    <label for="group_name">
                        '. lang['groups'] .' '. lang['name'] .'
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                </div>
            </fieldset>
        </div>
        <div class="col-md-8">
            <fieldset>
                <div class="form-floating">
                    <input type="text" class="form-control" name="group_alias" id="group_alias"
                        placeholder="'. lang['groups'] .' '.  lang['alias']  .'" required>
                    <label for="group_alias">
                        '. lang['groups'] .' '. lang['alias'] .'
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                </div>
            </fieldset>
        </div>

        <div class="col-md-2">
            <fieldset>
                <div class="form-group">
                    <label for="floatingInput">
                        '. lang['groups'] .' '. lang['color'] .'
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                    <input type="color" class="form-control form-control-color" name="group_color" id="group_color"
                        value="'.'#'. substr(str_shuffle(" 0123456789abcdef"), 6, 6) .'" required>
                </div>
            </fieldset>
        </div>

        <div class="col-8">
            <div class="form-group">
                <button type="submit" class="btn btn-outline-success w-100" name="submit_group" value="submit">
                    '. lang['add'] .'
                </button>
            </div>
        </div>
    </div>
</form>';