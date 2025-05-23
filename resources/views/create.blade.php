<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Entrega</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session("success") }}',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    @endif
    <form method="POST" action="{{ route('acta_entrega.guardar') }}" target="_blank">
        @csrf
        <section>
            <h1>Acta de Entrega</h1>
            <div class="card border-info mb-1">
                <div class="card-header bg-info text-black"><b>Datos Principales</b></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <center><img src="{{asset('imagenes/medicina.png')}}" style="width:100px;height:100px"></center>
                        </div>
                        <div class="col-md-10">
                            <label><strong>Empresa:</strong> INSTITUTO DE ENFERMEDADES DIGESTIVAS</label><br><br>
                            <label><strong>Direccion:</strong> Av. Abel R. Castillo S/N y Av Juan Tanca Marengo</label><br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-info mb-4">
                <div class="card-header bg-info text-black"><b>Datos del Paciente</b></div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label for="cedula">Buscar Paciente:</label>
                            <select id="buscar_paciente" name="buscar_paciente" style="width: 100%;" class="form-control" required></select>
                        </div>
                        <div class="col-md-3">
                            <label for="nombre_paciente">Nombre:</label>
                            <input type="text" name="nombre_paciente" id="nombre_paciente" class="form-control" placeholder="Nombre" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="direccion_paciente">Dirección:</label>
                            <input type="text" name="direccion_paciente" id="direccion_paciente" class="form-control" placeholder="Dirección" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="telefono_paciente">Telefono:</label>
                            <input type="text" name="telefono_paciente" id="telefono_paciente" class="form-control" placeholder="Dirección" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card body">
                <table class="table table-hover">
                    <thead style="text-align: center; " class="table-primary">
                        <tr>
                            <th style="width: 50%;">Producto</th>
                            <th style="width: 15%;">Cantidad</th>
                            <th style="width: 15%;">Precio</th>
                            <th style="width: 15%;">Valor total</th>
                            <th style="width: 5%;"><button onclick="agregarFila()" class="btn btn-success">+</button></th>
                        </tr>
                    </thead>
                    <tbody id="detalleProductos">

                    </tbody>
                    <tfoot class="table-primary">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Subtotal 15%:</td>
                            <td class="text-end">
                                <span id="subtotal15_span">0.00</span>
                                <input type="hidden" id="subtotal15" name="subtotal15">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Subtotal 0%:</td>
                            <td class="text-end">
                                <span id="subtotal0_span">0.00</span>
                                <input type="hidden" id="subtotal0" name="subtotal0">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Final:</td>
                            <td class="text-end">
                                <span id="totalFinal_span">0.00</span>
                                <input type="hidden" id="totalFinal" name="totalFinal">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <center>
            <button type="submit" class="btn btn-success" style="margin: 10px;"><i class="fa-solid fa-file"></i> Generar</button>
            <a href="{{ route('actaentrega.create') }}" class="btn btn-primary">Nuevo</a>
        </center>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

<script type="text/javascript">
    $(document).ready(function() {
        agregarFila();
        $('#buscar_paciente').select2({
            placeholder: 'Ingrese cedula o nombre...',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: "{{ route('actaentrega.buscar_paciente') }}",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(p => ({
                            id: p.id,
                            text: p.id + ' - ' + p.nombre1 + ' ' + p.nombre2 + ' ' + p.apellido1 + ' ' + p.apellido2,
                            direccion: p.direccion,
                            nombre: p.nombre1 + ' ' + p.nombre2 + ' ' + p.apellido1 + ' ' + p.apellido2,
                            telefono: p.telefono
                        }))
                    };
                },
                cache: true
            }
        });
        $('#buscar_paciente').on('select2:select', function(e) {
            const data = e.params.data;
            $('#nombre_paciente').val(data.nombre);
            $('#direccion_paciente').val(data.direccion);
            $('#telefono_paciente').val(data.telefono);
        });
        $('#buscar_paciente').on('select2:clear', function() {
            $('#nombre_paciente').val('');
            $('#direccion_paciente').val('');
            $('#telefono_paciente').val('');
        });
        $('#buscar_paciente').on('select2:open', function() {
            setTimeout(() => {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 0);
        });
    });

    function agregarFila() {
        const tbody = document.getElementById('detalleProductos');
        const fila = document.createElement('tr');
        fila.innerHTML = `
        <td><select name="producto[]" class="producto form-control" style="width: 100%" required></select></td>
        <td><input name="cantidad[]" type="number" min="1" value="1" onchange="calcularTotal(this)" class="form-control cantidad text-center"></td>
        <td><input name="precio[]" type="number" min="0" value="0.00" step="0.01" onchange="calcularTotal(this)" class="form-control precio text-end" readonly></td>
        <td><input name="valor_total[]" type="text" value="0" readonly class="form-control total text-end"></td>
        <td><button onclick="eliminarFila(this)" style="background: none; color: red; border: none; padding: 0px"><i class="fa fa-trash"></i></button></td>`;
        tbody.appendChild(fila);

        $(fila).find('.producto').select2({
            placeholder: 'Escriba el nombre del producto...',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: "{{ route('actaentrega.buscar_producto') }}",
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: data.map(p => ({
                            id: p.id,
                            text: p.nombre,
                            precio: p.precio
                        }))
                    };
                }
            }
        }).on('select2:select', function(e) {
            const precio = e.params.data.precio;
            const row = $(this).closest('tr');
            row.find('.precio').val(precio);
            row.find('.cantidad').trigger('change');
        }).on('select2:clear', function() {
            const row = $(this).closest('tr');
            row.find('.precio').val('0.00');
            row.find('.total').val('0.00');
            row.find('.cantidad').val('1');
            actualizarTotales()
        }).on('select2:open', function() {
            setTimeout(() => {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 0);
        });
    }

    function eliminarFila(boton) {
        const fila = boton.closest('tr');
        Swal.fire({
            title: '¿Desea Eliminar el registro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'red',
            cancelButtonColor: 'blue',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fila.remove();
                Swal.fire('¡Eliminado!', 'La fila ha sido eliminada.', 'success');
                actualizarTotales();
            }
        });
    }

    function calcularTotal(input) {
        const fila = input.closest('tr');
        const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(fila.querySelector('.precio').value) || 0;
        const total = fila.querySelector('.total');
        total.value = (cantidad * precio).toFixed(2);
        actualizarTotales();
    }

    function actualizarTotales() {
        let subtotal15 = 0;
        let subtotal0 = 0;
        const filas = document.querySelectorAll('#detalleProductos tr');
        filas.forEach(fila => {
            const precio = parseFloat(fila.querySelector('.precio').value) || 0;
            const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
            const totalFila = precio * cantidad;

            subtotal0 += totalFila;

        });
        document.getElementById('subtotal15_span').innerText = subtotal15.toFixed(2);
        document.getElementById('subtotal0_span').innerText = subtotal0.toFixed(2);
        document.getElementById('totalFinal_span').innerText = (subtotal15 + subtotal0).toFixed(2);

        document.getElementById('subtotal15').value = subtotal15.toFixed(2);
        document.getElementById('subtotal0').value = subtotal0.toFixed(2);
        document.getElementById('totalFinal').value = (subtotal15 + subtotal0).toFixed(2);
    }
</script>

</html>