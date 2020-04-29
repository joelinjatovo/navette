@extends('user/base')

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Informations</h4>
            <p class="card-category">*Bien remplir les champs avant de commander</p>
          </div>
          <div class="card-body">
            <form>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Réservation au nom de</label>
                    <input type="text" class="form-control" >
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Nombre de passager</label>
                    <input type="number" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Adresse de ramassage</label>
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group pb-0">
                    <label class="bmd-label-floating mb-0">Club (Destination) : </label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <select class="browser-default form-control-sm custom-select">
                      <option selected>club - 1</option>
                      <option value="1">club - 2</option>
                      <option value="2">club - 3</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group pb-0">
                    <label class="bmd-label-floating mb-0">Type de course : </label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <select class="browser-default form-control-sm custom-select">
                      <option selected>Aller Simple</option>
                      <option value="1">Retour Simple</option>
                      <option value="2">Aller - Retour</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <!-- Default unchecked -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                        <label class="custom-control-label" for="defaultUnchecked">Privatiser le véhicule</label>
                    </div>
                  </div>
                </div>

              </div>
              <button type="submit" class="btn btn-primary pull-right">Commander</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card card-profile">
          <div class="card-body">
            <div style="width: 100%"><iframe width="100%" height="600" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;coord=46.603354, 1.8883335&amp;q=France%2C%20Country%2C%20France+(Navette)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/draw-radius-circle-map/">Radius map tool</a></iframe></div><br />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection