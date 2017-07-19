<?php
if ($response) {
    foreach ($response as $text) {
        var_dump($response);
    }
}
?>
<form method="post" action="<?php echo $action; ?>">
    <table style="width:100%;">
        <tbody>
            <tr>
                <td>Name</td>
                <td>Description</td>
                <td style="width:20%;">Value</td>
            </tr>
            <?php
            foreach ($configs as $id => $conf) {
                ?>  
                <tr>                
                    <td><?php echo $conf['name']; ?></td>                
                    <td><?php echo $conf['description']; ?></td>                
                    <td>
                        <input type="text" name="<?php echo $id; ?>" 
                               value="<?php echo $conf['value'] ?>" />
                    </td>                                
                </tr>
                <?php
            }
            ?>        
        </tbody>
    </table>
    <input type="submit" value="Save" />
</form>
