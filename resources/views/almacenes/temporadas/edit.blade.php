<div class="modal inmodal" id="modal_editar_temporada" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Temporada</h4>
                <small class="font-bold" onkeyup="return mayus(this)">Modificar Temporada.</small>
            </div>
            <form role="form" action="{{ route('almacenes.temporada.update') }}" method="POST" id="editar_temporada">
                <div class="modal-body">

                    {{ csrf_field() }} {{ method_field('PUT') }}

                    <input type="hidden" name="tabla_id" id="tabla_id_editar" value="{{ old('tabla_id') }}">
                    <input type="hidden" name="temporada_existe" id="temporada_existe">
                    <div class="form-group">
                        <label class="required">Temporada:</label>
                        <input type="text" class="form-control {{ $errors->has('temporada') ? ' is-invalid' : '' }}"
                            name="nombre" id="temporada_editar" value="{{ old('temporada') }}" onkeyup="return mayus(this)"
                            required>

                        @if ($errors->has('temporada'))
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-temporada">{{ $errors->first('temporada') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-6 text-left" style="temporada:#fcbc6c">
                        <i class="fa fa-exclamation-circle"></i> <small>Los campos temporadados con asterisco (<label
                                class="required"></label>) son obligatorios.</small>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                            Guardar</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                                class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#temporada_editar").on("change", validarNombre);
        })


        $('#editar_temporada').submit(function(e) {
            e.preventDefault();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    container: 'my-swal',
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false
            })
            // if ($('#temporada_existe').val() == '0') {
                Swal.fire({
                    customClass: {
                        container: 'my-swal'
                    },
                    title: 'Opción Guardar',
                    text: "¿Seguro que desea guardar cambios?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {

                        this.submit();

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })
            // }



        })

        function validarNombre() {
            // Consultamos nuestra BBDD
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: '{{ route('almacenes.temporada.exist') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $(this).val(),
                    'id': $('#tabla_id_editar').val(),
                }
            }).done(function(result) {
                if (result.existe == true) {
                    toastr.error('La temporada ya se encuentra registrada', 'Error');
                    $(this).focus();
                    $('#temporada_existe').val('1')
                } else {
                    $('#temporada_existe').val('0')
                }
            });
        }
    </script>
@endpush
