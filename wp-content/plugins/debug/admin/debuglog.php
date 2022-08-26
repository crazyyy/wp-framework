<?php
if (!defined('ABSPATH')) {
     exit();
}?>
<style>
    #debug-log{
        max-width: 100%;
        padding: 10px;
        word-wrap: break-word;
        background: black;
        color: #fff;
        border-radius: 5px;
        height: 400px;
        overflow-y: auto;
    }
</style>
<div class="wrap">
    <h2><?php _e('Debug Log','debug');?></h2>
    <?php
    if (isset($_POST['clearlog'])) {
        $responce = debug_clearlog()
        ?>
        <div class="<?php echo $responce['class'];?> settings-error"> 
            <p><strong><?php echo $responce['message'];?></strong></p>
        </div>
        <?php
    }
    $content = debug_file_read('wp-content/debug.log');
    if($content !== false){
        echo '<form method="post" action="">';
        echo '<p style="  float: right;margin-top: -32px;"><input type="submit" name="clearlog" id="clearlog" class="button button-primary" value="'.__('Clear Log','debug').'">';
        echo '&nbsp;&nbsp;<input type="submit" name="downloadlog" id="downloadlog" class="button button-primary" value="'.__('Download Log','debug').'">';
        echo '</p></form>';
        echo '<pre id="debug-log">'.htmlentities($content).'</pre>';
    }else{
        echo '<div class="notice settings-error">';
        echo '<p><strong>'.__('No Log File Found','debug').'</strong></p>';
        echo '</div>';
    }
    echo debug_footer_link();
    ?>
</div>
