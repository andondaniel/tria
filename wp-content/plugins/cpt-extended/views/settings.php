<div class="wrap">
    <h2>Custom Post Types Extended - Settings</h2>

    <form method="post" action="options.php">
        <input type="hidden" name="option_page" value="general">
        <input type="hidden" name="action" value="update">
        <input type="hidden" id="_wpnonce" name="_wpnonce" value="b045253b36">
        <input type="hidden" name="_wp_http_referer" value="/tria/wp-admin/options-general.php">

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="admin_email">E-mail Address </label></th>
                    <td>
                        <input name="admin_email" type="text" id="admin_email" class="regular-text ltr">
                        <p class="description">This address is used for admin purposes, like new user notification.</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>
</div>