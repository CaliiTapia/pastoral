//$( "#region" ).change(function() {
function getComuna(id){
    //var id = $(this).val();
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:  {'idregion':id},
        url:   '/ajax/region',
        type : 'get',
        dataType: 'json',
    }).done(function(data) {
        $('#comuna').empty();
        $('#comuna').append('<option value="0" disabled="true" selected="true">--Seleccione una Comuna--</option>');
        $.each(data.comunas, function(index,comunasObj){
            // console.log(comunasObj.IdComuna);
            $('#comuna').append('<option value="'+comunasObj.IdComuna +'">'+ comunasObj.Nombre +'</option>');
        })
       
    });
}