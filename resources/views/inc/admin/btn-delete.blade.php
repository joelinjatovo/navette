<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            var $this = $(this);
            swal.fire({
                title:"Vous êtes sûre?",
                text:"Vous ne pourez pas revenir en arrière après!",
                type:"warning",
                showCancelButton:!0,
                confirmButtonText:"Oui, supprimez la!",
                cancelButtonText:"Annuler"
            }).then(function(e){
                if(e.value){
                    swal.fire({
                        title: '',
                        html: '<div class="save_loading"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div><div><h4>Save in progress...</h4></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    axios.delete('{{ $path }}' + $this.attr('data-id'))
                        .then(res => {
                            swal.close();
                            if (res.data.code === 200){
                                $this.closest('tr').remove();
                                $.notify({icon:"add_alert", message:res.data.message}, {type:"success"});
                            }else{
                                $.notify({icon:"add_alert", message:res.data.message}, {type:"danger"});
                            }
                        }).catch(err => {
                            console.log(err);
                            swal.close();
                        })
                }
            })
        });
    });
</script>