<br>
<br>
<div class="col-md-12 text-center">
    <?php echo wait_to_send?>
</div>


<form id="form1" action="https://pna.shaparak.ir/_ipgw_/payment/" method="post">
    <input type="hidden" id="token" name="token" value="<?php echo $list['gspt'] ?>" />
    <input type="hidden" id="language" name="language" value="fa" size="5px"/>
</form>
<script>
    $('form').submit();
</script>
<?php die();?>