<?php
if (isset($_GET['hash'])) { ?>
<script type="text/javascript" src="https://mediacru.sh/static/mediacrush.js"></script>
<a href="delete.php?hash=<?php echo $_GET['hash']; ?>">Click here to delete this file.</a>
<div class="mediacrush" data-media="<?php echo $_GET['hash']; ?>"></div>
<?php } else {
    header('Location: /snapcrush/index.php');
}
