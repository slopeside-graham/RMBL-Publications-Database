<?php

use PUBS\Utils;

function register_pubs_admin_settings()
{
    register_setting('pubs-pages-admin-group', 'pubs-dbhost');
    register_setting('pubs-pages-admin-group', 'pubs-dbport');
    register_setting('pubs-pages-admin-group', 'pubs-dbuser');
    register_setting('pubs-pages-admin-group', 'pubs-dbpassword', 'encryptpubssetting');
    register_setting('pubs-pages-admin-group', 'pubs-dbname');
}
add_action('admin_init', 'register_pubs_admin_settings');

function encryptpubssetting($setting)
{
    return Utils::encrypt($setting);
}

function pubs_settings()
{
?>
    <div class="wrap">
        <h1>RMBL Publications Database Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('pubs-pages-admin-group'); ?>
            <?php do_settings_sections('pubs-pages-admin-group'); ?>
            <table>
                <th class="table-header table-section-header" scope="row">
                    Database Information:
                </th>
                </tr>
                <tr>
                    <th class="table-header" scope="row">
                        Database Name:
                    </th>
                    <td>
                        <input required name="pubs-dbname" value="<?php echo Utils::getunencryptedsetting('pubs-dbname'); ?>">
                    </td>
                </tr>
                <tr>
                    <th class="table-header" scope="row">
                        Database User:
                    </th>
                    <td>
                        <input required name="pubs-dbuser" value="<?php echo Utils::getunencryptedsetting('pubs-dbuser'); ?>">
                    </td>
                </tr>
                <tr>
                    <th class="table-header" scope="row">
                        Database Password:
                    </th>
                    <td>
                        <input required name="pubs-dbpassword" value="<?php echo Utils::getencryptedsetting('pubs-dbpassword'); ?>">
                    </td>
                </tr>
                <tr>
                    <th class="table-header" scope="row">
                        Database Host:
                    </th>
                    <td>
                        <input required name="pubs-dbhost" value="<?php echo Utils::getunencryptedsetting('pubs-dbhost'); ?>">
                    </td>
                </tr>
                <tr>
                    <th class="table-header" scope="row">
                        Database Port:
                    </th>
                    <td>
                        <input required name="pubs-dbport" value="<?php echo Utils::getunencryptedsetting('pubs-dbport'); ?>">
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
?>