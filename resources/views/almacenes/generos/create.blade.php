<div class="modal inmodal" id="modal_crear_genero" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Genero</h4>
                <small class="font-bold">Crear nuevo Genero.</small>
            </div>
            <div class="modal-body">
                <input type="hidden" name="genero_existe" id="genero_existe">
                <form role="form" action="{{ route('almacenes.genero.store') }}" method="POST" id="crear_genero">
                    {{ csrf_field() }} {{ method_field('POST') }}

                    <div class="form-group">
                        <label class="required">Genero:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('genero_guardar') ? ' is-invalid' : '' }}"
                            name="genero_guardar" id="genero_guardar" value="{{ old('genero_guardar') }}"
                            onkeyup="return mayus(this)" required>

                        @if ($errors->has('genero_guardar'))
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-genero-guardar">{{ $errors->first('genero_guardar') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-6 text-left" style="genero:#fcbc6c">
                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label
                            class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
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
            $("#genero_guardar").on("change", validarNombre);
        })


        $('#crear_marca').submit(function(e) {
            e.preventDefault();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    container: 'my-swal',
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false
            })

            if ($('#genero_existe').val() == '0') {
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
            }



        })

        function validarNombre() {
            // Consultamos nuestra BBDD
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: '{{ route('almacenes.genero.exist') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $(this).val(),
                    'id': null
                }
            }).done(function(result) {
                if (result.existe == true) {
                    toastr.error('La genero ya se encuentra registrada', 'Error');
                    $(this).focus();
                    $('#genero_existe').val('1')
                } else {
                    $('#genero_existe').val('0')
                }
            });
        }
    </script>
@endpush
