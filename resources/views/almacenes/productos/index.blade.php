@extends('layout') @section('content')
@section('almacenes-active', 'active')
@section('producto-active', 'active')
@include('almacenes.productos.modalfile')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
        <h2 style="text-transform:uppercase"><b>Listado de Productos Terminados</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Productos</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <button id="btn_añadir_producto" class="btn btn-block btn-w-m btn-primary m-t-md">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </button>
        <a class="btn btn-block btn-w-m btn-primary m-t-md btn-modal-file" href="#">
            <i class="fa fa-plus-square"></i> Importar Excel
        </a>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Productos</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="div_productos">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="row align-items-end">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Categoria</label>
                                        <select name="categoria_id" id="categoria_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Marca</label>
                                        <select name="marca_id" id="marca_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Color</label>
                                        <select name="color_id" id="color_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Modelo</label>
                                        <select name="modelo_id" id="modelo_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Tela</label>
                                        <select name="tela_id" id="tela_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Talla</label>
                                        <select name="talla_id" id="talla_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Submodelo</label>
                                        <select name="sub_modelo_id" id="sub_modelo_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Temporada</label>
                                        <select name="temporada_id" id="temporada_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="">Genero</label>
                                        <select name="genero_id" id="genero_id" class="select2_form form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <button class="btn btn-warning" onclick="loadFilterable()"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-1">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" onclick="getExcel()"><i class="fa fa-file-excel-o"></i></button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table dataTables-producto table-striped table-bordered table-hover"
                                    style="text-transform:uppercase" id="table_productos">
                                    <thead>
                                        <tr>
                                            <th class="text-center">CÓDIGO</th>
                                            <th class="text-center">CÓDIGO BARRA</th>
                                            <th class="text-center">NOMBRE</th>
                                            <th class="text-center">ALMACEN</th>
                                            <th class="text-center">MARCA</th>
                                            <th class="text-center">CATEGORIA</th>
                                            <th class="text-center">STOCK</th>
                                            <th class="text-center">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('almacenes.productos.modalIngreso')

@stop
@push('styles')
<!-- DataTable -->
<link href="{{ asset('Inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<style>


</style>
@endpush

@push('scripts')
<!-- DataTable -->
<script src="{{ asset('Inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {

        loadFilterable();

        $(".select2_form").select2({
            placeholder: "SELECCIONAR",
            allowClear: true,
            height: '200px',
            width: '100%',
        });

        

        $('buttons-html5').removeClass('.btn-default');
        $('#table_productos_wrapper').removeClass('');
        $('.dataTables-productos tbody').on( 'click', 'tr', function () {
                $('.dataTables-productos').DataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
        } );

        // Eventos
        $('#btn_añadir_producto').on('click', añadirProducto);

        $('#categoria_id').select2({
            ajax: {
                url: route('almacenes.categoria.getListSelect'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                },
                cache: true,
            },
            allowClear: true,
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#marca_id').select2({
            ajax: {
                url: route('almacenes.marca.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            allowClear: true,
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#color_id').select2({
            ajax: {
                url: route('almacenes.color.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            allowClear: true,
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#modelo_id').select2({            
            allowClear: true,
            ajax: {
                url: route('almacenes.modelo.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#tela_id').select2({            
            allowClear: true,
            ajax: {
                url: route('almacenes.tela.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#talla_id').select2({            
            allowClear: true,
            ajax: {
                url: route('almacenes.talla.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#sub_modelo_id').select2({            
            allowClear: true,
            ajax: {
                url: route('almacenes.submodelo.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#temporada_id').select2({            
            allowClear: true,
            ajax: {
                url: route('almacenes.temporada.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });

        $('#genero_id').select2({            
            allowClear: true,
            ajax: {
                url: route('almacenes.genero.getListSelect'),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.total
                        }
                    };
                }
            },
            placeholder: 'Seleccionar',
            language: {

                errorLoading: function () {
                    return 'No se pudo cargar el resultado.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Por favor borrar ' + overChars + ' caracteres';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Por favor ingrese ' + remainingChars + ' o mas caracteres';

                    return message;
                },
                loadingMore: function () {
                    return 'Cargando más recursos...';
                },
                maximumSelected: function (args) {
                    var message = 'Puedes elegir ' + args.maximum + ' articulos';

                    if (args.maximum  >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                return 'No hay resultados';
                },
                searching: function () {
                return 'Buscando…';
                }
            }
        });
    });

    function loadFilterable() {
         $('.dataTables-producto').DataTable().destroy();
        // DataTables
        let categoria_id = $("#categoria_id").val();
        let marca_id = $("#marca_id").val();
        let color_id = $("#color_id").val();
        let modelo_id = $("#modelo_id").val();
        let tela_id = $("#tela_id").val();
        let talla_id = $("#talla_id").val();
        let sub_modelo_id = $("#sub_modelo_id").val();
        let temporada_id = $("#temporada_id").val();
        let genero_id = $("#genero_id").val();
        $('.dataTables-producto').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'PRODUCTOS'
                },

                {
                    titleAttr: 'Imprimir',
                    extend: 'print',
                    text:      '<i class="fa fa-print"></i> Imprimir',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }
            ],
            "bPaginate": true,
            "serverSide":true,
            "processing":true,
            "bLengthChange": true,
            "bFilter": true,
            "order": [],
            "bInfo": true,
            'bAutoWidth': false,
            "ajax": {
                url: "{{ route('almacenes.producto.getTable') }}",
                type: 'GET',
                data: {
                    categoria_id: categoria_id,
                    marca_id: marca_id,
                    color_id: color_id,
                    modelo_id: modelo_id,
                    tela_id: tela_id,
                    talla_id: talla_id,
                    sub_modelo_id: sub_modelo_id,
                    temporada_id: temporada_id,
                    genero_id: genero_id,
                }
            },
            "columns": [{
                    data: 'codigo',
                    className: "text-left",
                    name:"productos.codigo"
                },
                {
                    data: 'codigo_barra',
                    className: "text-left",
                    name:"productos.codigo_barra"
                },
                {
                    data: 'nombre',
                    className: "text-left",
                    name:"productos.nombre"
                },
                {
                    data: 'almacen',
                    className: "text-left",
                    name:"almacenes.descripcion"
                },
                {
                    data: 'marca',
                    className: "text-left",
                    name:"marcas.marca"
                },
                {
                    data: 'categoria',
                    className: "text-left",
                    name:"categorias.descripcion"
                },
                {
                    data: 'stock',
                    className: "text-center",
                    name:"productos.stock"
                },
                {
                    data: null,
                    defaultContent: "",
                    searchable: false,
                    className: "text-center",
                    render: function(data) {
                        //Ruta Detalle
                        var url_detalle = '{{ route('almacenes.producto.show', ':id') }}';
                        url_detalle = url_detalle.replace(':id', data.id);

                        //Ruta Modificar
                        var url_editar = '{{ route('almacenes.producto.edit', ':id') }}';
                        url_editar = url_editar.replace(':id', data.id);

                        return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +

                            "<li><a class='dropdown-item' href='" + url_detalle +"' title='Detalle'><i class='fa fa-eye'></i> Ver</a></b></li>" +
                            "<li><a class='dropdown-item modificarDetalle' href='" + url_editar + "' title='Modificar'><i class='fa fa-edit'></i> Editar</a></b></li>" +
                            "<li><a class='dropdown-item' href='#' onclick='eliminar(" + data.id + ")' title='Eliminar'><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                            "<li class='dropdown-divider'></li>" +

                            "<li><a class='dropdown-item nuevo-ingreso' href='#' title='Ingreso'><i class='fa fa-save'></i> Ingreso</a></b></li>" +

                        "</ul></div>";
                    }
                }

            ],
            "language": {
                "url": "{{ asset('Spanish.json') }}"
            },
            createdRow: function(row, data, dataIndex, cells) {
                $(row).addClass('fila_lote');
                $(row).attr('data-href', "");
            },
        });
    }

    function getExcel() {
        let categoria_id = $("#categoria_id").val();
        let marca_id = $("#marca_id").val();
        let color_id = $("#color_id").val();
        let modelo_id = $("#modelo_id").val();
        let tela_id = $("#tela_id").val();
        let talla_id = $("#talla_id").val();
        let sub_modelo_id = $("#sub_modelo_id").val();
        let temporada_id = $("#temporada_id").val();
        let genero_id = $("#genero_id").val();
        location = '/almacenes/productos/getExcel?categoria_id=' + categoria_id+'&marca_id='+marca_id+'&color_id='+color_id+'&modelo_id='+modelo_id+'&tela_id='+tela_id+'&talla_id='+talla_id+'&sub_modelo_id='+sub_modelo_id+'&temporada_id='+temporada_id+'&genero_id='+genero_id;
    }

    $(".dataTables-producto").on('click','.nuevo-ingreso',function(){
        var data = $(".dataTables-producto").dataTable().fnGetData($(this).closest('tr'));

        $('#modal_ingreso').modal('show');
        $('#cantidad_fast').val('');
        $('#producto_id_fast').val(data.id);
        setTimeout(function() { $('#cantidad_fast').focus() }, 10);

    });




    //Controlar Error
    $.fn.DataTable.ext.errMode = 'throw';

    //Modal Eliminar
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    });

    // Funciones de Eventos
    function añadirProducto() {
        window.location = "{{ route('almacenes.producto.create') }}";
    }

    function editarCliente(url) {
        window.location = url;
    }

    function eliminar(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })
        Swal.fire({
            title: 'Opción Eliminar',
            text: "¿Seguro que desea guardar cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                //Ruta Eliminar
                var url_eliminar = '{{ route('almacenes.producto.destroy', ':id') }}';
                url_eliminar = url_eliminar.replace(':id', id);
                $(location).attr('href', url_eliminar);

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'La Solicitud se ha cancelado.',
                    'error'
                )
            }
        })
    }
    $(".btn-modal-file").on('click', function() {
        $("#modal_file").modal("show");
    });
</script>
@endpush
