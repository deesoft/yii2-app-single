$('#btn-execute').click(function(){
    var migration = [];
    $('#migration-list :checked').each(function (){
        migration.push($(this).val());
    });
    
    $.post($(this).prop('href'),{migration:migration},function(r){
        $('#result').text(r);
    });
    return false;
});