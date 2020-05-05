@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">{{ __('messages.clubs.list') }}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-shopping">
              <thead>
                <tr>
                  <th class="text-center"></th>
                  <th>Product</th>
                  <th class="th-description">Color</th>
                  <th class="th-description">Size</th>
                  <th class="text-right">Price</th>
                  <th class="text-right">Amount</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($models as $model)
                <tr>
                  <td>
                    <div class="img-container"><img src="{{ $model->image ? asset($model->image->url) : '/img/product1.jpg' }}" alt="..."></div>
                  </td>
                  <td class="td-name">
                    <a href="{{ route('admin.club.show', $model)}}">{{ $model->name }}</a>
                    <br>
                    <small>by Dolce&amp;Gabbana</small>
                  </td>
                  <td>Red</td>
                  <td>M</td>
                  <td class="td-number text-right"><small>€</small>549</td>
                  <td class="td-number"><small>€</small>549</td>
                  <td class="td-actions">
                    <button type="button" rel="tooltip" data-placement="left" title="" class="btn btn-link btn-delete" data-id="{{ $model->getKey() }}" data-original-title="Remove item">
                      <i class="material-icons">close</i>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('javascript')
@parent
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            var $this = $(this);
            swal.fire({
                title:"Vous êtes sûre?",
                text:"Vous ne pourez pas revenir en arrière après!\nToutes les rapports ainsi que les données rattachées à cette activité vont être supprimés aussi.",
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
                    axios.delete(`/admin/club/` + $this.attr('data-id'))
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
@endsection
