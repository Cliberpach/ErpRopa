<div class="modal inmodal" id="modal_talla" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiarTalla()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Talla</h4>
                <small class="font-bold">Crear Talla.</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre_talla" id="nombre_talla" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-left" style="talla:#fcbc6c">
                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label
                            class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-primary btn-sm create-talla" style="talla:white"><i
                            class="fa fa-save"></i>
                        Guardar</a>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                            class="fa fa-times"></i>
                        Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(".create-talla").on('click', async function() {
            let talla = $("#nombre_talla").val();
            let create = true;
            if (talla == "") {
                toastr.error("Ingrese todo los datos", "Error");
                create = false;
            } else {
                await axios.post(route("almacenes.talla.exist", {
                    _token: $('input[name=_token]').val(),
                    nombre: talla,
                    id: ""
                })).then((value) => {
                    let response = value.data;
                    if (response.existe) {
                        toastr.error('La talla ya se encuentra registrada', 'Error');
                        create = false;
                    }
                })
            }
            if (create) {
                await axios.post(route('almacenes.talla.storeApi'), {
                    _token: $('input[name=_token]').val(),
                    nombre: talla
                }).then((value) => {
                    let response = value.data;
                    if (response.success) {
                        var newOption = new Option(response.data.nombre, response.data.id, true,
                            true);
                        $('#talla_id').append(newOption).trigger('change');
                        $("#modal_talla").modal("hide");
                    } else {
                        toastr.error("ocurrio un error");
                    }
                }).catch((value) => {
                    toastr.error("ocurrio un error");
                })
            }
        })

        function limpiarTalla() {
            $("#nombre_talla").val("");
        }
    </script>
@endpush
