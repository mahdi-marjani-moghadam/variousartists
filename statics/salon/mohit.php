<style>
    .st0{opacity:0.1;fill:#FCFCFC;stroke:#000000;stroke-miterlimit:10;}
    .st1{opacity:0.5;fill:#FCFCFC;stroke:#000000;stroke-miterlimit:10;}
    svg{width: 100% !important; height: auto !important}
    #mobl:hover,.st1:hover{ fill: #fffb2c; opacity:1;}

    .fill{'fill':'#1790b1','opacity':'.8'}
</style>
<? include_once('all1.svg') ?>
<script>
    $('.st0 , .st1').click(function (e) {

        //$(this).css({'fill':'#1790b1','opacity':'.8'});
        //$(this).addClass('fill');

        var id = $(this).attr('id');
        var input = $('input[data-item='+id+']');
        if(input.is(':checked')){
            input.prop('checked',false);
            $(this).css({'fill':'#FCFCFC','opacity':'.5'});
        }else{
            input.prop('checked',true);
            $(this).css({'fill':'#1790b1','opacity':'.8'});
        }
    });
</script>




<?php  foreach ($list['sandali'] as $k => $x):?>
    <label for="sandali<?=$x?>" class="btn-default btn margin topmargin-sm" style="float: none" ><?=$x?>
        <input id="sandali<?=$x?>"  data-item="tbl<?=$k?>" type="checkbox" name="sandali[<?=$x?>]"  value="<?=$x?>">
    </label>
<?endforeach; ?>

