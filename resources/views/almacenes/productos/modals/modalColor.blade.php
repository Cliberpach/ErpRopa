<div class="modal inmodal" id="modal_color" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiarColor()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Color</h4>
                <small class="font-bold">Crear Color.</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre_color" id="nombre_color" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-left" style="color:#fcbc6c">
                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label
                            class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-primary btn-sm create-color" style="color:white"><i
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
        $(".create-color").on('click', async function() {
            let color = $("#nombre_color").val();
            let create = true;
            if (color == "") {
                toastr.error("Ingrese todo los datos", "Error");
                create = false;
            } else {
                await axios.post(route("almacenes.color.exist", {
                    _token: $('input[name=_token]').val(),
                    nombre: color,
                    id: ""
                })).then((value) => {
                    let response = value.data;
                    if (response.existe) {
                        toastr.error('La color ya se encuentra registrada', 'Error');
                        create = false;
                    }
                })
            }
            if (create) {
                await axios.post(route('almacenes.color.storeApi'), {
                    _token: $('input[name=_token]').val(),
                    nombre: color
                }).then((value) => {
                    let response = value.data;
                    if (response.success) {
                        var newOption = new Option(response.data.nombre, response.data.id, true,
                            true);
                        $('#color_id').append(newOption).trigger('change');
                        $("#modal_color").modal("hide");
                    } else {
                        toastr.error("ocurrio un error");
                    }
                }).catch((value) => {
                    toastr.error("ocurrio un error");
                })
            }
        })

        function limpiarColor() {
            $("#nombre_color").val("");
        }
    </script>
@endpush
