<style>
    svg{width: 100% !important; height: auto !important; direction: ltr}
    rect,text{cursor: pointer;}
    .fill{'fill':'#1790b1','opacity':'.8'}
    text{fill: #fff; width: 30px; text-align: center; font-size: 16px !important; font-family: 'iransans', sans-serif !important}


</style>
<? include('tech-cafe.svg') ?>
<script>
    $(document).ready(function () {
        $('rect').each(function (num,element) {
            num = num + 1;
            var chair = $(this).data('name');

            var id = element.id;
            $('rect#'+id).attr('data-chair',chair);
            $('rect#'+id).next('text').attr('data-chair',chair);

        });

    });


    $('rect,text').click(function (e) {

        var num = $(this).data('chair');


        var chair = $('input[data-input-chair='+num+']');
        var text = $('text[data-chair='+num+']');
        console.log(chair);

        if(chair.is(':checked')) {
            chair.prop('checked', false);
            text.prop('checked', false);
            $('rect[data-chair=' + num + ']').css({'fill-opacity': '0'});
        }
        else{
            chair.prop('checked',true);
            $('rect[data-chair='+num+']').css({'fill':'#1790b1','fill-opacity':'.8'});
        }
    });

</script>


<?php  foreach ($list['sandali'] as $k => $x):?>
    <label  for="sandali<?=$x?>" class="btn-default btn margin topmargin-sm" style="display: none" ><?=$x?>
        <input id="sandali<?=$x?>" class="sandali"  data-input-chair="<?=$k+1?>" type="checkbox" name="sandali[<?=$x?>]"  value="<?=$x?>">
    </label>
<?endforeach; ?>


<script>
    $(document).ready(function (e) {
        $('rect').each(function (i,item) {
            //var num = i+1;
            var num = $(this).data('chair');
            var notExist = 0;


            $('.sandali').each(function (j,chair) {
                if(num === $(this).data('input-chair'))
                {
                    notExist++;
                }
            });

            if(notExist === 0){
                console.log('chair '+num + ' not exit');
                $('rect[data-chair='+num+']').css({'fill':'#bc1d1e','fill-opacity':'.9'});

                $('rect[data-chair='+num+']').data('chair','-1');
                $('text[data-chair='+num+']').data('chair','-1');

            }
        });
    });
</script>