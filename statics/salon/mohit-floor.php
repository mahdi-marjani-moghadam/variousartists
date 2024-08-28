<style>
    .st0{opacity:0.1;fill:#FCFCFC;stroke:#000000;stroke-miterlimit:10;}
    .st1{opacity:0.5;fill:#FCFCFC;stroke:#000000;stroke-miterlimit:10;}
    svg{width: 100% !important; height: auto !important}
    #mobl:hover,.st1:hover{ fill: #fffb2c; opacity:1;}

    .fill{'fill':'#1790b1','opacity':'.8'}
</style>
<?php include('mohit-floor.svg') ?>
<script>
    $('.st1').click(function (e) {
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
    <label  for="sandali<?php echo $x?>" class="btn-default btn margin topmargin-sm" style="display: none" ><?php echo $x?>
        <input id="sandali<?php echo $x?>" class="sandali"  data-item="tbl<?php echo $k+1?>" type="checkbox" name="sandali[<?php echo $x?>]"  value="<?php echo $x?>">
    </label>
<?endforeach; ?>


<script>
    $(document).ready(function (e) {
        $('.st1').each(function (i,item) {
            var notExist = 0;

            $('.sandali').each(function (j,chair) {
                if(item.id === $(this).data('item'))
                {
                    notExist++;
                }
            });
            if(notExist === 0){
                console.log(item.id + ' not exit');
                $('#'+item.id).css({'fill':'#1790b1','opacity':'.8'});
            }
        });
    });
</script>