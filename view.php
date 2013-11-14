<?php
if (isset($_GET['hash'])) {
$response = json_decode(file_get_contents("https://mediacru.sh/api/".$_GET['hash']."/exists"), true);
if (!$response['exists']) {
    echo "File has been deleted. <a href='index.php'>Click here</a> to upload a new file!";
} else { ?>
<script type="text/javascript" src="https://mediacru.sh/static/mediacrush.js"></script>
<a href="delete.php?hash=<?php echo $_GET['hash']; ?>">Click here to delete this file.</a>
<div class="mediacrush" data-media="<?php echo $_GET['hash']; ?>"></div>
<?php } } else {
    header('Location: /snapcrush/index.php');
}
